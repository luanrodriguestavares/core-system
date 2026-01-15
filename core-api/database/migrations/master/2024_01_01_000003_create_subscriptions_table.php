<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('master')->create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('plan_id');
            $table->string('status')->default('active');
            $table->string('gateway')->nullable();
            $table->string('gateway_customer_id')->nullable();
            $table->string('gateway_subscription_id')->nullable();
            $table->timestamp('next_charge_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('master')->dropIfExists('subscriptions');
    }
};
