<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('contact_email')->nullable();
            $table->string('source', 50)->nullable();
            $table->timestamp('claimed_at')->nullable();
            $table->foreignId('resume_id')->nullable()->constrained()->nullOnDelete();
            $table->text('cover_letter')->nullable();
            $table->string('status')->default('applied');
            $table->unsignedSmallInteger('match_score')->nullable();
            $table->json('match_breakdown')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['job_listing_id', 'user_id']);
            $table->unique(['job_listing_id', 'contact_email'], 'applicants_job_listing_contact_email_unique');
            $table->index('contact_email');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
