<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketing_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('source', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('source');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketing_leads');
    }
};
