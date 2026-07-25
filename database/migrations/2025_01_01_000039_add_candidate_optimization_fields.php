<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('optimizations', function (Blueprint $table) {
            $table->json('optimized_content')->nullable()->after('heatmap');
            $table->text('failure_reason')->nullable()->after('optimized_content');
            $table->timestamp('started_at')->nullable()->after('failure_reason');
            $table->timestamp('completed_at')->nullable()->after('started_at');
            $table->timestamp('failed_at')->nullable()->after('completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('optimizations', function (Blueprint $table) {
            $table->dropColumn([
                'optimized_content',
                'failure_reason',
                'started_at',
                'completed_at',
                'failed_at',
            ]);
        });
    }
};
