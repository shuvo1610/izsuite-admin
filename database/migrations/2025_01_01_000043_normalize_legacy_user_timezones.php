<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Legacy timezone aliases that should be normalized.
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

    public function up(): void
    {
        foreach (self::LEGACY_ALIASES as $legacy => $canonical) {
            DB::table('users')
                ->where('timezone', $legacy)
                ->update(['timezone' => $canonical]);
        }
    }

    public function down(): void
    {
        foreach (self::LEGACY_ALIASES as $legacy => $canonical) {
            DB::table('users')
                ->where('timezone', $canonical)
                ->update(['timezone' => $legacy]);
        }
    }
};
