<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('optimizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('resume_id')->constrained()->cascadeOnDelete();
            $table->text('job_description')->nullable();
            $table->string('target_role')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedSmallInteger('score')->nullable();
            $table->json('report')->nullable();
            $table->json('heatmap')->nullable();
            $table->boolean('credits_consumed')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('optimizations');
    }
};
