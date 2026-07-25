<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('plans')) {
            return;
        }

        $data = [
            'description' => 'Free recruiter starter plan.',
        ];

        foreach ([
            'plan_for'            => 'recruiter',
            'job_postings_limit'  => 1,
            'ai_screenings_limit' => 10,
            'team_members_limit'  => 1,
        ] as $column => $value) {
            if (Schema::hasColumn('plans', $column)) {
                $data[$column] = $value;
            }
        }

        DB::table('plans')->where('slug', 'free')->update($data);
    }

    public function down(): void
    {
        // Keep existing plan data intact.
    }
};
