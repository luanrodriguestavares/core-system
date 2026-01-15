<?php

namespace App\Billing;

use App\Billing\Gateways\BillingGatewayInterface;
use App\Billing\Gateways\MercadoPagoGateway;
use App\Billing\Gateways\NullGateway;
use InvalidArgumentException;

class BillingManager
{
    public function resolve(): BillingGatewayInterface
    {
        $gateway = config('billing.gateway');

        return match ($gateway) {
            'mercadopago' => app(MercadoPagoGateway::class),
            'null' => app(NullGateway::class),
            default => throw new InvalidArgumentException('Unsupported billing gateway.'),
        };
    }
}
