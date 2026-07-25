<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'affiliate_code')) {
                $table->string('affiliate_code')->nullable()->unique()->after('remember_token');
            }

            if (! Schema::hasColumn('users', 'affiliate_enabled_at')) {
                $table->timestamp('affiliate_enabled_at')->nullable()->after('affiliate_code');
            }
        });

        Schema::create('affiliate_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('referred_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('referral_code');
            $table->string('signup_ip', 45)->nullable();
            $table->string('signup_user_agent')->nullable();
            $table->timestamps();

            $table->unique('referred_user_id');
            $table->index(['affiliate_user_id', 'created_at']);
            $table->index('referral_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliate_referrals');

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'affiliate_enabled_at')) {
                $table->dropColumn('affiliate_enabled_at');
            }

            if (Schema::hasColumn('users', 'affiliate_code')) {
                $table->dropUnique(['affiliate_code']);
                $table->dropColumn('affiliate_code');
            }
        });
    }
};
