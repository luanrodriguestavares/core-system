<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    protected $connection = 'master';

    protected $fillable = [
        'gateway',
        'event_id',
        'payload',
    ];
}
