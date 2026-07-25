<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('subscriptions')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                if (! Schema::hasColumn('subscriptions', 'payment_id')) {
                    $table->string('payment_id')->nullable()->after('currency');
                }

                if (! Schema::hasColumn('subscriptions', 'cancelled_at')) {
                    $table->timestamp('cancelled_at')->nullable()->after('last_charged_date');
                }
            });
        }

        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                if (! Schema::hasColumn('invoices', 'subscription_id')) {
                    $table->foreignId('subscription_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
                }

                if (Schema::hasColumn('invoices', 'user_plan_id')) {
                    $table->dropConstrainedForeignId('user_plan_id');
                }
            });
        }

        Schema::dropIfExists('user_plans');
    }

    public function down(): void
    {
        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                if (! Schema::hasColumn('invoices', 'user_plan_id')) {
                    $table->foreignId('user_plan_id')->nullable()->after('user_id');
                }

                if (Schema::hasColumn('invoices', 'subscription_id')) {
                    $table->dropConstrainedForeignId('subscription_id');
                }
            });
        }

        if (Schema::hasTable('subscriptions')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                foreach (['payment_id', 'cancelled_at'] as $column) {
                    if (Schema::hasColumn('subscriptions', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
