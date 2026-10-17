<?php

namespace App\Support;

final class NikProtection
{
    public static function normalize(string $nik): string
    {
        return preg_replace('/\D+/', '', trim($nik)) ?? '';
    }

    public static function fingerprint(?string $nik): string
    {
        $normalized = self::normalize((string) $nik);
        $applicationKey = (string) config('app.key');

        if (str_starts_with($applicationKey, 'base64:')) {
            $decoded = base64_decode(substr($applicationKey, 7), true);
            $applicationKey = $decoded === false ? '' : $decoded;
        }

        if ($applicationKey === '') {
            throw new \RuntimeException('APP_KEY must be configured to protect NIK data.');
        }

        $fingerprintKey = hash_hmac('sha256', 'web-nu:member-nik-fingerprint:v1', $applicationKey, true);

        return hash_hmac('sha256', $normalized, $fingerprintKey);
    }
}
