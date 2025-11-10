<?php

namespace App\Helpers;

use Carbon\Carbon;
use Exception;
use Illuminate\Filesystem\Filesystem;

final class Blacklist
{
    private Filesystem $filesystem;

    private string $blacklistFile;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->blacklistFile = storage_path('app/blacklist.json');
    }

    public function create(string $ip, string $userAgent, int $ttlMinutes = 5): bool
    {
        try {
            $now = now();
            $blacklist = $this->get($ttlMinutes);
            $newBlacklist = [];

            // Remove existing entry for same IP/UA to update TTL
            foreach ($blacklist as $entry) {
                if (!($entry['ip'] === $ip && $entry['user_agent'] === $userAgent)) {
                    $newBlacklist[] = $entry;
                }
            }

            // Add new entry with specified TTL
            $newBlacklist[] = [
                'ip' => $ip,
                'user_agent' => $userAgent,
                'waktu' => $now->toDateTimeString(),
                'ttl' => $ttlMinutes,
                'reason' => 'Suspicious activity detected',
            ];

            $this->save($newBlacklist);

            return true;
        } catch (Exception) {
            return false;
        }
    }

    public function get(int $ttlMinutes = 5): array
    {
        try {
            if (!$this->filesystem->exists($this->blacklistFile)) {
                $this->filesystem->put($this->blacklistFile, '[]');
            }

            $content = $this->filesystem->get($this->blacklistFile);
            $decoded = json_decode($content, true);

            if (!is_array($decoded)) {
                return [];
            }

            $now = now();
            $filtered = [];

            foreach ($decoded as $entry) {
                if (isset($entry['waktu'])) {
                    $entryTime = Carbon::parse($entry['waktu']);
                    $entryTtl = $entry['ttl'] ?? $ttlMinutes;
                    if ($now->diffInMinutes($entryTime) <= $entryTtl) {
                        $filtered[] = $entry;
                    }
                }
            }

            if (empty($filtered)) {
                if ($this->filesystem->exists($this->blacklistFile)) {
                    $this->filesystem->delete($this->blacklistFile);
                }
            } else {
                $this->save($filtered);
            }

            return $filtered;
        } catch (Exception) {
            return [];
        }
    }

    public function delete(string $ip, string $userAgent): bool
    {
        try {
            $blacklist = $this->get();

            $filtered = array_filter($blacklist, function ($entry) use ($ip, $userAgent) {
                return !($entry['ip'] === $ip && $entry['user_agent'] === $userAgent);
            });

            $filtered = array_values($filtered);

            if (empty($filtered)) {
                $this->filesystem->delete($this->blacklistFile);
            } else {
                $this->save($filtered);
            }

            return true;
        } catch (Exception) {
            return false;
        }
    }

    public function save(array $blacklist): void
    {
        $this->filesystem->put(
            $this->blacklistFile,
            json_encode($blacklist, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        );
    }

    public function isBlacklisted(string $ip, string $userAgent, int $ttlMinutes = 5): bool
    {
        try {
            $now = Carbon::now();
            $blacklist = $this->get($ttlMinutes);

            foreach ($blacklist as $entry) {
                if ($entry['ip'] === $ip && $entry['user_agent'] === $userAgent) {
                    $entryTime = Carbon::parse($entry['waktu']);
                    $entryTtl = $entry['ttl'] ?? $ttlMinutes;
                    $diff = $entryTime->diffInMinutes($now);
                    if ($diff >= 0 && $diff <= $entryTtl) {
                        return true;
                    }
                }
            }

            return false;
        } catch (Exception) {
            return false;
        }
    }
}
