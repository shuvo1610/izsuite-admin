<?php

namespace App\Support;

class Timezone
{
    public const UTC             = 'UTC';

    /**
     * Legacy aliases that may still exist in old payloads or DB rows.
     */
    private const LEGACY_ALIASES = [
        'Africa/Asmera'         => 'Africa/Asmara',
        'America/Buenos_Aires'  => 'America/Argentina/Buenos_Aires',
        'America/Catamarca'     => 'America/Argentina/Catamarca',
        'America/Coral_Harbour' => 'America/Atikokan',
        'America/Cordoba'       => 'America/Argentina/Cordoba',
        'America/Godthab'       => 'America/Nuuk',
        'America/Indianapolis'  => 'America/Indiana/Indianapolis',
        'America/Jujuy'         => 'America/Argentina/Jujuy',
        'America/Louisville'    => 'America/Kentucky/Louisville',
        'America/Mendoza'       => 'America/Argentina/Mendoza',
        'Asia/Calcutta'         => 'Asia/Kolkata',
        'Asia/Katmandu'         => 'Asia/Kathmandu',
        'Asia/Rangoon'          => 'Asia/Yangon',
        'Asia/Saigon'           => 'Asia/Ho_Chi_Minh',
        'Atlantic/Faeroe'       => 'Atlantic/Faroe',
        'Europe/Kiev'           => 'Europe/Kyiv',
        'Pacific/Enderbury'     => 'Pacific/Kanton',
        'Pacific/Ponape'        => 'Pacific/Pohnpei',
        'Pacific/Truk'          => 'Pacific/Chuuk',
    ];

    /**
     * @return array<string, true>
     */
    public static function validMap(): array
    {
        static $map     = null;

        if (is_array($map)) {
            return $map;
        }

        $map            = array_fill_keys(timezone_identifiers_list(), true);
        $map[self::UTC] = true;

        return $map;
    }

    public static function normalize(?string $timezone): ?string
    {
        if ($timezone === null) {
            return null;
        }

        $timezone = trim($timezone);

        if ($timezone === '') {
            return null;
        }

        return self::LEGACY_ALIASES[$timezone] ?? $timezone;
    }

    public static function isValid(?string $timezone): bool
    {
        $normalized = self::normalize($timezone);

        if (! $normalized) {
            return false;
        }

        return isset(self::validMap()[$normalized]);
    }

    public static function resolve(?string $timezone, string $fallback = self::UTC): string
    {
        $fallback   = self::normalize($fallback) ?? self::UTC;

        if (! self::isValid($fallback)) {
            $fallback = self::UTC;
        }

        $normalized = self::normalize($timezone);

        return self::isValid($normalized) ? $normalized : $fallback;
    }
}
