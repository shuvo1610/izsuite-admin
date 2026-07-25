<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::table('roles')->where('slug', 'affiliate')->exists()) {
            DB::table('roles')->insert([
                'id'          => 100,
                'name'        => 'Affiliate',
                'slug'        => 'affiliate',
                'permissions' => json_encode([]),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('roles')->where('slug', 'affiliate')->delete();
    }
};
