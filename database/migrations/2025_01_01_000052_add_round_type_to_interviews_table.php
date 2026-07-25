<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            if (! Schema::hasColumn('interviews', 'round_type')) {
                $table->string('round_type')->nullable()->after('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            if (Schema::hasColumn('interviews', 'round_type')) {
                $table->dropColumn('round_type');
            }
        });
    }
};
