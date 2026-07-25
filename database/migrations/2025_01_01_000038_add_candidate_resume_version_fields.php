<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->foreignId('parent_resume_id')->nullable()->after('user_id')->constrained('resumes')->nullOnDelete();
            $table->foreignId('source_optimization_id')->nullable()->after('parent_resume_id')->constrained('optimizations')->nullOnDelete();
            $table->string('version_label')->nullable()->after('name');
            $table->unsignedSmallInteger('latest_score')->nullable()->after('format');
            $table->timestamp('archived_at')->nullable()->after('status');

            $table->index(['user_id', 'latest_score']);
        });
    }

    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'latest_score']);
            $table->dropConstrainedForeignId('parent_resume_id');
            $table->dropConstrainedForeignId('source_optimization_id');
            $table->dropColumn([
                'version_label',
                'latest_score',
                'archived_at',
            ]);
        });
    }
};
