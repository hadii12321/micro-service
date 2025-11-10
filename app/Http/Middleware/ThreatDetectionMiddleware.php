<?php

namespace App\Http\Middleware;

use App\Helpers\Blacklist;
use App\Helpers\Tools;
use App\Helpers\UserAgent;
use App\Models\Threat\ThreatActivityLogs;
use App\Models\Threat\ThreatBlackListLogs;
use App\Models\Threat\ThreatLogs;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ThreatDetectionMiddleware
{
    private const int GEO_CACHE_TTL = 14400;

    private const int SPAM_MAX_REQUESTS = 10;

    private const int SPAM_WINDOW_SECONDS = 60;

    private const int GEO_API_TIMEOUT = 2;

    private const int MAX_PARAM_LENGTH = 200;

    private const array ALLOWED_METHODS = ['GET', 'POST'];

    private const array EXEMPT_PATHS = ['log-viewer/*'];

    private readonly Blacklist $blackList;

    public function __construct(Blacklist $blackList)
    {
        $this->blackList = $blackList;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $ua = $this->sanitizeUserAgent($request->userAgent());
        $method = $request->method();
        $geo = $this->getGeo($ip);
        $info = UserAgent::getClientInfo($ua);

        if ($request->is(self::EXEMPT_PATHS)) {
            return $next($request);
        }

        if (empty($ua)) {
            return $this->errorResponse($request, 405);
        }

        if (!in_array($method, self::ALLOWED_METHODS, true)) {
            return $this->errorResponse($request, 405);
        }

        if (($info['threat_level'] ?? 'high') === 'high') {
            $this->logThreat($request, $geo);

            return $this->errorResponse($request, 405);
        }

        if (($info['browser'] ?? 'unknown') === 'unknown' || ($info['os'] ?? 'unknown') === 'unknown') {
            $this->logThreat($request, $geo);

            return $this->errorResponse($request, 405);
        }

        if (!($info['is_legitimate'] ?? false)) {
            $this->logThreat($request, $geo);

            return $this->errorResponse($request, 405);
        }

        if (Tools::isPrivateIp($ip)) {
            return $next($request);
        }

        if ($this->blackList->isBlacklisted($ip, $ua)) {
            return $this->errorResponse($request, 429);
        }

        $response = $next($request);
        $statusCode = $response->getStatusCode();

        if ($this->isSuccessfulResponse($statusCode)) {
            $this->logActivityThreat($request, $geo);
        }

        return $response;
    }

    private function sanitizeUserAgent(?string $ua): string
    {
        if (empty($ua)) {
            return '';
        }

        $ua = trim($ua);
        $ua = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $ua) ?: '';

        return strlen($ua) > 600 ? substr($ua, 0, 600) : $ua;
    }

    private function getGeo(string $ip): array
    {
        if (Tools::isPrivateIp($ip)) {
            return $this->getDefaultGeoData($ip);
        }

        $cacheKey = "geoip:$ip";

        return Cache::remember($cacheKey, self::GEO_CACHE_TTL, function () use ($ip) {
            try {
                $ctx = stream_context_create([
                    'http' => [
                        'timeout' => self::GEO_API_TIMEOUT,
                        'user_agent' => 'SIMPEG-ThreatDetection/1.0',
                        'method' => 'GET',
                    ],
                ]);

                $response = @file_get_contents("http://ip-api.com/json/$ip", false, $ctx);

                if ($response === false) {
                    return $this->getDefaultGeoData($ip);
                }

                $geo = json_decode($response, true);

                if (json_last_error() !== JSON_ERROR_NONE || !is_array($geo)) {
                    return $this->getDefaultGeoData($ip);
                }

                return $this->normalizeGeoData($geo, $ip);
            } catch (Throwable) {
                return $this->getDefaultGeoData($ip);
            }
        });
    }

    private function getDefaultGeoData(string $ip): array
    {
        return [
            'country' => 'Indonesia',
            'countryCode' => 'ID',
            'region' => 'JI',
            'regionName' => 'East Java',
            'city' => 'Probolinggo',
            'zip' => '',
            'lat' => '',
            'lon' => '',
            'timezone' => 'Asia/Jakarta',
            'isp' => 'unuja',
            'org' => '',
            'as' => '',
            'query' => $ip,
        ];
    }

    private function normalizeGeoData(array $geo, string $ip): array
    {
        return [
            'country' => $geo['country'] ?? 'unknown',
            'countryCode' => $geo['countryCode'] ?? '-',
            'region' => $geo['region'] ?? '',
            'regionName' => $geo['regionName'] ?? '',
            'city' => $geo['city'] ?? 'unknown',
            'zip' => $geo['zip'] ?? '',
            'lat' => $geo['lat'] ?? '',
            'lon' => $geo['lon'] ?? '',
            'timezone' => $geo['timezone'] ?? '',
            'isp' => $geo['isp'] ?? 'unknown',
            'org' => $geo['org'] ?? '',
            'as' => $geo['as'] ?? '',
            'query' => $geo['query'] ?? $ip,
        ];
    }

    private function errorResponse(Request $request, int $code): Response|JsonResponse
    {
        return $request->wantsJson()
            ? response()->json($this->errorPayload($code), $code)
            : response()->view("errors.$code", [], $code);
    }

    private function errorPayload(int $code): array
    {
        return match ($code) {
            405 => [
                'success' => false,
                'message' => 'Konfigurasi server menolak akses ke sumber daya (URI) karena pembatasan metode',
            ],
            429 => [
                'success' => false,
                'message' => 'Anda telah mengirim terlalu banyak permintaan, coba lagi nanti',
            ],
            default => [
                'success' => false,
                'message' => 'Akses ditolak',
            ],
        };
    }

    private function logThreat(Request $request, array $geo): void
    {
        try {
            $info = UserAgent::getClientInfo($request->userAgent());
            $summaryBody = $this->sanitizeRequestParameters($request);

            $threatCategory = match ($info['threat_level'] ?? 'unknown') {
                'high' => 'Bot/Suspicious-Agent',
                'medium' => 'Illegitimate-Browser',
                default => 'User-Agent-unknown'
            };

            $logData = array_merge(
                $this->extractGeoData($geo),
                [
                    'ip_address' => $request->ip(),
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'header_user_agent' => $request->userAgent(),
                    'referer' => $request->headers->get('referer'),
                    'parameters' => $summaryBody->isEmpty() ? null : json_encode(
                        $summaryBody,
                        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                    ),
                    'threat_category' => $threatCategory,
                    'threat_description' => $this->getThreatDescription($info),
                    'browser_detected' => $info['browser'] ?? 'unknown',
                    'os_detected' => $info['os'] ?? 'unknown',
                    'device_type' => $info['device_type'] ?? 'unknown',
                    'is_legitimate' => $info['is_legitimate'] ?? false,
                    'validation_score' => $info['validation_score'] ?? 0,
                ]
            );

            ThreatLogs::create($logData);

            // Cek spam dan blacklist jika perlu
            if ($this->isSpamming($request->ip(), $request->userAgent() ?? '')) {
                $this->logBlackListThreat($request, $geo);
            }
        } catch (Throwable) {
            // Silent fail - logging tidak critical
        }
    }

    private function sanitizeRequestParameters(Request $request): Collection
    {
        $excludedParams = ['_token', 'token', '_method', 'password', 'password_confirmation'];

        return collect($request->except($excludedParams))
            ->mapWithKeys(function ($val, $key) {
                return match (true) {
                    is_array($val) => [$key => '[array:' . count($val) . ' items]'],
                    is_object($val) => [$key => '[object:' . get_class($val) . ']'],
                    is_null($val) => [$key => null],
                    is_bool($val) => [$key => $val ? 'true' : 'false'],
                    is_numeric($val) => [$key => $val],
                    default => [$key => is_string($val)
                        ? substr($val, 0, self::MAX_PARAM_LENGTH)
                        : (string)$val],
                };
            });
    }

    private function extractGeoData(array $geo): array
    {
        return [
            'country' => $geo['country'] ?? null,
            'country_code' => $geo['countryCode'] ?? null,
            'region' => $geo['region'] ?? null,
            'region_name' => $geo['regionName'] ?? null,
            'city' => $geo['city'] ?? null,
            'zip' => $geo['zip'] ?? null,
            'lat' => $geo['lat'] ?? null,
            'lon' => $geo['lon'] ?? null,
            'timezone' => $geo['timezone'] ?? null,
            'isp' => $geo['isp'] ?? null,
            'org' => $geo['org'] ?? null,
            'as' => $geo['as'] ?? null,
        ];
    }

    private function getThreatDescription(array $info): string
    {
        $browser = $info['browser'] ?? 'unknown';
        $os = $info['os'] ?? 'unknown';
        $threatLevel = $info['threat_level'] ?? 'unknown';
        $score = $info['validation_score'] ?? 0;

        return match ($threatLevel) {
            'high' => "Bot/Scraper terdeteksi - Browser: {$browser}, OS: {$os}",
            'medium' => "Browser tidak legitimate (Score: {$score}) - Browser: {$browser}, OS: {$os}",
            default => "User-Agent tidak dikenal - Browser: {$browser}, OS: {$os}"
        };
    }

    private function isSpamming(
        string $ip,
        string $ua
    ): bool
    {
        if (empty($ip) || empty($ua)) {
            return false;
        }

        $key = 'spam:' . hash('sha256', $ip . '|' . $ua);

        try {
            $count = Cache::increment($key);

            if ($count === 1) {
                Cache::put($key, 1, self::SPAM_WINDOW_SECONDS);
            }

            return $count > self::SPAM_MAX_REQUESTS;
        } catch (Throwable) {
            return false;
        }
    }

    private function logBlackListThreat(Request $request, array $geo): void
    {
        try {
            $ip = $request->ip();
            $ua = $request->userAgent() ?? '';

            $this->blackList->create($ip, $ua);

            $key = 'spam:' . hash('sha256', $ip . '|' . $ua);
            Cache::forget($key);

            $logData = array_merge(
                $this->extractGeoData($geo),
                [
                    'ip_address' => $ip,
                    'header_user_agent' => $ua,
                ]
            );

            ThreatBlackListLogs::create($logData);
        } catch (Throwable) {
            // Silent fail
        }
    }

    private function errorCountries(Request $request): Response|JsonResponse
    {
        return $request->wantsJson()
            ? response()->json([
                'success' => false,
                'message' => 'Simpeg ini hanya dapat diakses pada zona yang sudah terdaftar',
            ], 403)
            : response()->view('errors.country', [], 403);
    }

    private function isSuccessfulResponse(int $statusCode): bool
    {
        return ($statusCode >= 200 && $statusCode <= 299) ||
            ($statusCode >= 300 && $statusCode <= 399);
    }

    private function logActivityThreat(Request $request, array $geo): void
    {
        try {
            $info = UserAgent::getClientInfo($request->userAgent());

            $logData = array_merge(
                $this->extractGeoData($geo),
                [
                    'ip_address' => $request->ip(),
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'header_user_agent' => $request->userAgent(),
                    'referer' => $request->headers->get('referer'),
                    'browser_detected' => $info['browser'] ?? 'unknown',
                    'os_detected' => $info['os'] ?? 'unknown',
                    'device_type' => $info['device_type'] ?? 'unknown',
                    'validation_score' => $info['validation_score'] ?? 0,
                ]
            );

            ThreatActivityLogs::create($logData);
        } catch (Throwable) {
            // Silent fail
        }
    }
}
