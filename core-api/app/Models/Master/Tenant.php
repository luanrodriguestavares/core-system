<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $connection = 'master';

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'db_name',
        'db_user',
        'db_pass',
        'db_host',
        'db_port',
        'status',
        'plan_id',
    ];
}
