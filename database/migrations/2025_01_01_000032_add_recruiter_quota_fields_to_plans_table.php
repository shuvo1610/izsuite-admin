<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('plans')) {
            return;
        }

        Schema::table('plans', function (Blueprint $table) {
            if (! Schema::hasColumn('plans', 'plan_for')) {
                $table->enum('plan_for', ['recruiter', 'candidate'])->default('recruiter')->after('slug');
            }

            if (! Schema::hasColumn('plans', 'job_postings_limit')) {
                $table->unsignedInteger('job_postings_limit')->nullable()->after('features');
            }

            if (! Schema::hasColumn('plans', 'ai_screenings_limit')) {
                $table->unsignedInteger('ai_screenings_limit')->nullable()->after('job_postings_limit');
            }

            if (! Schema::hasColumn('plans', 'team_members_limit')) {
                $table->unsignedInteger('team_members_limit')->nullable()->after('ai_screenings_limit');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('plans')) {
            return;
        }

        Schema::table('plans', function (Blueprint $table) {
            foreach (['plan_for', 'job_postings_limit', 'ai_screenings_limit', 'team_members_limit'] as $column) {
                if (Schema::hasColumn('plans', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
