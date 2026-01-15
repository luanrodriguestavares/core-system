<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $connection = 'master';

    protected $fillable = [
        'tenant_id',
        'plan_id',
        'status',
        'gateway',
        'gateway_customer_id',
        'gateway_subscription_id',
        'next_charge_at',
    ];
}
