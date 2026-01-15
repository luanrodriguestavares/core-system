<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class MasterUser extends Model
{
    protected $connection = 'master';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
}
