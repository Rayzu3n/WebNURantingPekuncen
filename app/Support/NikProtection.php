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
        $fingerprintSecret = (string) config('app.nik_hash_key');

        if (strlen($fingerprintSecret) < 32) {
            throw new \RuntimeException('NIK_HASH_KEY must be configured with at least 32 characters to protect NIK data.');
        }

        $fingerprintKey = hash_hmac('sha256', 'web-nu:member-nik-fingerprint:v1', $fingerprintSecret, true);

        return hash_hmac('sha256', $normalized, $fingerprintKey);
    }
}
