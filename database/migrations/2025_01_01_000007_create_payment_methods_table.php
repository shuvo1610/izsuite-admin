<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['offline', 'online']);
            $table->string('name');                          // "Stripe", "Bank Transfer", etc.
            $table->string('slug')->unique();                // stripe, paypal, bank-transfer
            $table->string('logo_url')->nullable();          // gateway logo
            $table->text('description')->nullable();         // admin note / short description
            $table->text('instructions')->nullable();        // offline: payment instructions shown to user
            $table->json('credentials')->nullable();         // online: api keys, secrets, webhook urls
            $table->boolean('is_active')->default(false);
            $table->boolean('is_sandbox')->default(false);   // online: sandbox / live toggle
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
