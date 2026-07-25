<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('optimizations', function (Blueprint $table) {
            $table->timestamp('applied_at')->nullable()->after('failed_at');
            $table->string('rescore_status')->nullable()->after('applied_at');
            $table->unsignedSmallInteger('score_before_apply')->nullable()->after('rescore_status');
            $table->unsignedSmallInteger('score_after_apply')->nullable()->after('score_before_apply');
            $table->json('rescore_report')->nullable()->after('score_after_apply');
            $table->json('rescore_heatmap')->nullable()->after('rescore_report');
            $table->text('rescore_failure_reason')->nullable()->after('rescore_heatmap');
            $table->timestamp('rescore_started_at')->nullable()->after('rescore_failure_reason');
            $table->timestamp('rescored_at')->nullable()->after('rescore_started_at');

            $table->index(['user_id', 'rescore_status']);
        });
    }

    public function down(): void
    {
        Schema::table('optimizations', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'rescore_status']);
            $table->dropColumn([
                'applied_at',
                'rescore_status',
                'score_before_apply',
                'score_after_apply',
                'rescore_report',
                'rescore_heatmap',
                'rescore_failure_reason',
                'rescore_started_at',
                'rescored_at',
            ]);
        });
    }
};
