<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('plans') && ! Schema::hasColumn('plans', 'billing_type')) {
            $afterColumn = Schema::hasColumn('plans', 'plan_for') ? 'plan_for' : 'slug';

            Schema::table('plans', fn (Blueprint $table) => $table->enum('billing_type', ['monthly', 'yearly'])->default('monthly')->after($afterColumn));
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('plans') && Schema::hasColumn('plans', 'billing_type')) {
            Schema::table('plans', function (Blueprint $table) {
                $table->dropColumn('billing_type');
            });
        }
    }
};
