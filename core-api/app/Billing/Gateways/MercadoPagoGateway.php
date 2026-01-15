<?php

namespace App\Billing\Gateways;

use App\Models\Master\Plan;
use App\Models\Master\Subscription;
use App\Models\Master\Tenant;
use Illuminate\Http\Request;

class MercadoPagoGateway implements BillingGatewayInterface
{
    public function createCustomer(Tenant $tenant, array $payload): array
    {
        return [
            'gateway_customer_id' => 'mp_customer_stub',
            'raw' => $payload,
        ];
    }

    public function createSubscription(Tenant $tenant, Plan $plan, array $paymentMethod): array
    {
        return [
            'gateway_subscription_id' => 'mp_subscription_stub',
            'status' => 'active',
            'raw' => [
                'plan' => $plan->id,
                'paymentMethod' => $paymentMethod,
            ],
        ];
    }

    public function cancelSubscription(Subscription $subscription): array
    {
        return [
            'status' => 'canceled',
        ];
    }

    public function getSubscriptionStatus(Subscription $subscription): array
    {
        return [
            'status' => $subscription->status,
        ];
    }

    public function handleWebhook(Request $request): array
    {
        return [
            'event_id' => $request->header('X-Event-Id', 'mp_event_stub'),
            'type' => $request->input('type', 'subscription.updated'),
            'payload' => $request->all(),
        ];
    }
}
