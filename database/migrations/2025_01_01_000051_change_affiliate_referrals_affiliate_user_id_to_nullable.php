<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('affiliate_referrals', function (Blueprint $table) {
            $table->dropForeign(['affiliate_user_id']);
            $table->unsignedBigInteger('affiliate_user_id')->nullable()->change();
            $table->foreign('affiliate_user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('affiliate_referrals', function (Blueprint $table) {
            $table->dropForeign(['affiliate_user_id']);
            $table->unsignedBigInteger('affiliate_user_id')->nullable(false)->change();
            $table->foreign('affiliate_user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
