<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $connection = 'master';

    protected $fillable = [
        'name',
        'price_cents',
        'interval',
        'features_json',
    ];
}
