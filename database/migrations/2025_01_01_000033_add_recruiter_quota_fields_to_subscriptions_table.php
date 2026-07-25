<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('subscriptions')) {
            return;
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            if (! Schema::hasColumn('subscriptions', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('subscriptions', 'plan_slug')) {
                $table->string('plan_slug')->nullable()->after('plan_id');
            }

            if (! Schema::hasColumn('subscriptions', 'payment_method_slug')) {
                $table->string('payment_method_slug')->nullable()->after('currency');
            }

            if (! Schema::hasColumn('subscriptions', 'job_postings_limit')) {
                $table->unsignedInteger('job_postings_limit')->nullable()->after('payment_method_slug');
            }

            if (! Schema::hasColumn('subscriptions', 'job_postings_used')) {
                $table->unsignedInteger('job_postings_used')->default(0)->after('job_postings_limit');
            }

            if (! Schema::hasColumn('subscriptions', 'ai_screenings_limit')) {
                $table->unsignedInteger('ai_screenings_limit')->nullable()->after('job_postings_used');
            }

            if (! Schema::hasColumn('subscriptions', 'ai_screenings_used')) {
                $table->unsignedInteger('ai_screenings_used')->default(0)->after('ai_screenings_limit');
            }

            if (! Schema::hasColumn('subscriptions', 'team_members_limit')) {
                $table->unsignedInteger('team_members_limit')->nullable()->after('ai_screenings_used');
            }

            if (! Schema::hasColumn('subscriptions', 'team_members_used')) {
                $table->unsignedInteger('team_members_used')->default(0)->after('team_members_limit');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('subscriptions')) {
            return;
        }

        Schema::table('subscriptions', function (Blueprint $table) {
            foreach ([
                'plan_id',
                'plan_slug',
                'payment_method_slug',
                'job_postings_limit',
                'job_postings_used',
                'ai_screenings_limit',
                'ai_screenings_used',
                'team_members_limit',
                'team_members_used',
            ] as $column) {
                if (Schema::hasColumn('subscriptions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
