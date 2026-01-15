<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $connection = 'master';

    protected $fillable = [
        'tenant_id',
        'subscription_id',
        'amount_cents',
        'status',
        'gateway_charge_id',
        'paid_at',
        'failure_reason',
    ];
}
