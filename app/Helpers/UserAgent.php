<?php

namespace App\Helpers;

final class UserAgent
{
    private const int MAX_UA_LENGTH = 600;

    private const int MIN_UA_LENGTH = 30;

    private const int MIN_WEBKIT_VERSION = 537;

    private const int MAX_WEBKIT_VERSION = 605;

    private const int LEGITIMACY_THRESHOLD = 70;

    private const array BROWSERS = [
        ['name' => 'edge', 'pattern' => 'edg(?:e|a|ios)?\/(\d+\.\d+)', 'engine' => 'webkit'],
        ['name' => 'brave', 'pattern' => 'brave\/(\d+\.\d+)', 'engine' => 'webkit'],
        ['name' => 'opera', 'pattern' => '(?:opr|opera)\/(\d+\.\d+)', 'engine' => 'webkit'],
        ['name' => 'firefox', 'pattern' => '(?:firefox|fxios)\/(\d+\.\d+)', 'engine' => 'gecko'],
        ['name' => 'safari', 'pattern' => 'version\/(\d+\.\d+).*safari(?!\/)', 'engine' => 'webkit'],
        ['name' => 'chrome', 'pattern' => '(?:chrome|crios)\/(\d+\.\d+)', 'engine' => 'webkit'],
    ];

    private const array OS = [
        ['name' => 'ios', 'pattern' => '(?:iphone|ipod).*os\s(\d+[_\d]*)', 'mobile' => true],
        ['name' => 'ipados', 'pattern' => 'ipad.*os\s(\d+[_\d]*)', 'mobile' => false],
        ['name' => 'android', 'pattern' => 'android\s(\d+(?:\.\d+)*)', 'mobile' => true],
        ['name' => 'windows', 'pattern' => 'windows nt\s(\d+\.\d+)', 'mobile' => false],
        ['name' => 'macos', 'pattern' => '(?:macintosh|mac os x)(?:.*?(\d+[_\d]*))?', 'mobile' => false],
        ['name' => 'linux', 'pattern' => 'linux(?!.*android)', 'mobile' => false],
        ['name' => 'chrome os', 'pattern' => 'cros\s.*?(\d+\.\d+)', 'mobile' => false],
    ];

    private const array BOT_INDICATORS = [
        'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
        'yandexbot', 'facebookexternalhit', 'twitterbot', 'linkedinbot',
        'curl', 'wget', 'python-requests', 'go-http-client',
        'postman', 'insomnia', 'guzzlehttp', 'okhttp', 'apache-httpclient',
        'headless', 'phantom', 'selenium', 'webdriver', 'puppeteer',
        'chrome-headless', 'firefox-headless', 'playwright',
    ];

    private const array BROWSER_COMPONENTS = [
        'chrome' => ['webkit', 'safari', 'chrome'],
        'firefox' => ['gecko', 'firefox'],
        'safari' => ['webkit', 'safari', 'version'],
        'edge' => ['webkit', 'chrome', 'edge'],
    ];

    private const array PLATFORM_INCONSISTENCIES = [
        'windows.*(?:iphone|android)' => 40,
        'macintosh.*android' => 40,
        'linux.*(?:iphone|ipad)' => 40,
        'iphone.*(?:windows|android)' => 40,
        'android.*(?:macintosh|windows)' => 40,
    ];

    private const array LOCAL_AGENTS = ['Symfony', 'Unuja-Agent'];

    public static function getClientInfo(?string $userAgent): array
    {
        if (empty($userAgent)) {
            return self::createResult('unknown', 'unknown', 'high', false);
        }

        $userAgent = self::sanitizeUserAgent($userAgent);
        if ($userAgent === '') {
            return self::createResult('unknown', 'unknown', 'high', false);
        }

        if (in_array($userAgent, self::LOCAL_AGENTS, true)) {
            return self::createResult('local', 'local', 'none', true, 'desktop');
        }

        $threatLevel = self::assessThreatLevel($userAgent);
        if ($threatLevel === 'high') {
            return self::createResult('unknown', 'unknown', 'high', false);
        }

        $browserInfo = self::detectBrowser($userAgent);
        $osInfo = self::detectOS($userAgent);

        if ($browserInfo['name'] === 'unknown' || $osInfo['name'] === 'unknown') {
            return self::createResult(
                $browserInfo['name'] ?? 'unknown',
                $osInfo['name'] ?? 'unknown',
                'medium',
                false
            );
        }

        $deviceType = self::determineDeviceType($userAgent, $osInfo);
        $legitimacy = self::validateFingerprint($userAgent, $browserInfo);

        $finalThreatLevel = $legitimacy['is_legitimate'] ? 'low' : 'medium';

        return [
            'browser' => $browserInfo['name'],
            'browser_version' => $browserInfo['version'] ?? null,
            'os' => $osInfo['name'],
            'os_version' => $osInfo['version'] ?? null,
            'device_type' => $deviceType,
            'is_legitimate' => $legitimacy['is_legitimate'],
            'threat_level' => $finalThreatLevel,
            'engine' => $browserInfo['engine'] ?? 'unknown',
            'validation_score' => $legitimacy['score'],
            'fingerprint_issues' => $legitimacy['issues'],
        ];
    }

    private static function createResult(
        string $browser,
        string $os,
        string $threatLevel,
        bool   $legitimate,
        string $deviceType = 'unknown'
    ): array
    {
        return [
            'browser' => $browser,
            'browser_version' => null,
            'os' => $os,
            'os_version' => null,
            'device_type' => $deviceType,
            'is_legitimate' => $legitimate,
            'threat_level' => $threatLevel,
            'engine' => 'unknown',
            'validation_score' => $legitimate ? 100 : 0,
            'fingerprint_issues' => [],
        ];
    }

    private static function sanitizeUserAgent(string $userAgent): string
    {
        $userAgent = trim($userAgent);

        if (strlen($userAgent) > self::MAX_UA_LENGTH) {
            $userAgent = substr($userAgent, 0, self::MAX_UA_LENGTH);
        }

        $userAgent = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $userAgent);

        return $userAgent ?: '';
    }

    private static function assessThreatLevel(string $userAgent): string
    {
        $userAgentLower = strtolower($userAgent);

        foreach (self::BOT_INDICATORS as $pattern) {
            if (str_contains($userAgentLower, $pattern)) {
                return 'high';
            }
        }

        $length = strlen($userAgent);
        if ($length < self::MIN_UA_LENGTH || $length > self::MAX_UA_LENGTH) {
            return 'medium';
        }

        if (preg_match('#^[a-zA-Z]{1,5}$|^\d+$|^[\*\-_]$#', $userAgent) === 1) {
            return 'high';
        }

        if (preg_match('#[<>"\'\\\\]#', $userAgent) === 1) {
            return 'high';
        }

        return 'low';
    }

    private static function detectBrowser(string $userAgent): array
    {
        foreach (self::BROWSERS as $browser) {
            $result = @preg_match('#' . $browser['pattern'] . '#i', $userAgent, $matches);

            if ($result === false) {
                continue;
            }

            if ($result === 1) {
                return [
                    'name' => $browser['name'],
                    'version' => $matches[1] ?? null,
                    'engine' => $browser['engine'],
                ];
            }
        }

        return ['name' => 'unknown', 'version' => null, 'engine' => 'unknown'];
    }

    private static function detectOS(string $userAgent): array
    {
        foreach (self::OS as $os) {
            $result = @preg_match('#' . $os['pattern'] . '#i', $userAgent, $matches);

            if ($result === false) {
                continue;
            }

            if ($result === 1) {
                $version = isset($matches[1]) ? str_replace('_', '.', $matches[1]) : null;

                return [
                    'name' => $os['name'],
                    'version' => $version,
                    'mobile' => $os['mobile'] ?? false,
                ];
            }
        }

        return ['name' => 'unknown', 'version' => null, 'mobile' => false];
    }

    private static function determineDeviceType(string $userAgent, array $osInfo): string
    {
        $isMobile = $osInfo['mobile'] ?? false;

        if ($isMobile) {
            $userAgentLower = strtolower($userAgent);
            if (str_contains($userAgentLower, 'tablet') || ($osInfo['name'] ?? '') === 'ipados') {
                return 'tablet';
            }

            return 'mobile';
        }

        return 'desktop';
    }

    private static function validateFingerprint(string $userAgent, array $browserInfo): array
    {
        $score = 100;
        $issues = [];
        $userAgentLower = strtolower($userAgent);

        $score = self::validateStructure($userAgent, $score, $issues);
        $score = self::validateComponents($userAgentLower, $browserInfo, $score, $issues);
        $score = self::validatePlatformConsistency($userAgentLower, $score, $issues);
        $score = self::validateEngineConsistency($userAgentLower, $browserInfo, $score, $issues);
        $score = self::validateWebKitVersion($userAgent, $browserInfo, $score, $issues);

        return [
            'is_legitimate' => $score >= self::LEGITIMACY_THRESHOLD,
            'score' => max(0, $score),
            'issues' => $issues,
        ];
    }

    private static function validateStructure(string $userAgent, int $score, array &$issues): int
    {
        if (@preg_match('#^mozilla\/[45]\.0\s*\(#i', $userAgent) !== 1) {
            $score -= 20;
            $issues[] = 'missing_mozilla_header';
        }

        if (@preg_match('#\([^)]+\)#', $userAgent) !== 1) {
            $score -= 15;
            $issues[] = 'missing_system_info';
        }

        if (@preg_match('#(?:webkit|gecko|trident|edge)\/\d+#i', $userAgent) !== 1) {
            $score -= 25;
            $issues[] = 'missing_engine_version';
        }

        return $score;
    }

    private static function validateComponents(string $userAgentLower, array $browserInfo, int $score, array &$issues): int
    {
        $browserName = $browserInfo['name'] ?? 'unknown';

        if (isset(self::BROWSER_COMPONENTS[$browserName])) {
            $required = self::BROWSER_COMPONENTS[$browserName];
            foreach ($required as $component) {
                if (!str_contains($userAgentLower, $component)) {
                    $score -= 20;
                    $issues[] = "missing_component_{$component}";
                }
            }
        }

        return $score;
    }

    private static function validatePlatformConsistency(string $userAgentLower, int $score, array &$issues): int
    {
        foreach (self::PLATFORM_INCONSISTENCIES as $pattern => $penalty) {
            $result = @preg_match("#{$pattern}#i", $userAgentLower);
            if ($result === 1) {
                $score -= $penalty;
                $issues[] = 'platform_inconsistency';
                break;
            }
        }

        return $score;
    }

    private static function validateEngineConsistency(string $userAgentLower, array $browserInfo, int $score, array &$issues): int
    {
        $engine = $browserInfo['engine'] ?? 'unknown';

        if ($engine === 'webkit' && !str_contains($userAgentLower, 'webkit')) {
            $score -= 25;
            $issues[] = 'missing_webkit_engine';
        }

        if ($engine === 'gecko' && !str_contains($userAgentLower, 'gecko')) {
            $score -= 25;
            $issues[] = 'missing_gecko_engine';
        }

        return $score;
    }

    private static function validateWebKitVersion(string $userAgent, array $browserInfo, int $score, array &$issues): int
    {
        $engine = $browserInfo['engine'] ?? 'unknown';

        if ($engine === 'webkit') {
            $result = @preg_match('#webkit\/(\d+)#i', $userAgent, $matches);
            if ($result === 1 && isset($matches[1])) {
                $webkitVersion = (int)$matches[1];
                if ($webkitVersion < self::MIN_WEBKIT_VERSION || $webkitVersion > self::MAX_WEBKIT_VERSION) {
                    $score -= 15;
                    $issues[] = 'webkit_version_suspicious';
                }
            }
        }

        return $score;
    }
}
