<?php

namespace App\Billing\Gateways;

use App\Models\Master\Plan;
use App\Models\Master\Subscription;
use App\Models\Master\Tenant;
use Illuminate\Http\Request;

interface BillingGatewayInterface
{
    public function createCustomer(Tenant $tenant, array $payload): array;

    public function createSubscription(Tenant $tenant, Plan $plan, array $paymentMethod): array;

    public function cancelSubscription(Subscription $subscription): array;

    public function getSubscriptionStatus(Subscription $subscription): array;

    public function handleWebhook(Request $request): array;
}
