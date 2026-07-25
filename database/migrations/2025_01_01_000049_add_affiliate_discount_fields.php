<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'affiliate_discount_type')) {
                $table->string('affiliate_discount_type')->nullable()->after('affiliate_enabled_at');
            }

            if (! Schema::hasColumn('users', 'affiliate_discount_value')) {
                $table->decimal('affiliate_discount_value', 10, 2)->nullable()->after('affiliate_discount_type');
            }

            if (! Schema::hasColumn('users', 'affiliate_discount_expires_at')) {
                $table->timestamp('affiliate_discount_expires_at')->nullable()->after('affiliate_discount_value');
            }
        });

        Schema::table('affiliate_referrals', function (Blueprint $table) {
            if (! Schema::hasColumn('affiliate_referrals', 'discount_type')) {
                $table->string('discount_type')->nullable()->after('referral_code');
            }

            if (! Schema::hasColumn('affiliate_referrals', 'discount_value')) {
                $table->decimal('discount_value', 10, 2)->nullable()->after('discount_type');
            }

            if (! Schema::hasColumn('affiliate_referrals', 'discount_expires_at')) {
                $table->timestamp('discount_expires_at')->nullable()->after('discount_value');
            }
        });
    }

    public function down(): void
    {
        Schema::table('affiliate_referrals', function (Blueprint $table) {
            foreach (['discount_expires_at', 'discount_value', 'discount_type'] as $column) {
                if (Schema::hasColumn('affiliate_referrals', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('users', function (Blueprint $table) {
            foreach (['affiliate_discount_expires_at', 'affiliate_discount_value', 'affiliate_discount_type'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
