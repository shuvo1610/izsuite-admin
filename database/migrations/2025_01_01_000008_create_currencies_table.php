<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);           // e.g. "US Dollar"
            $table->string('code', 10)->unique();   // e.g. "USD"
            $table->string('symbol', 10);           // e.g. "$"
            $table->decimal('exchange_rate', 12, 6)->default(1.000000); // relative to base
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
