<?php

namespace App\Models\Tenant;

class TenantUser extends TenantModel
{
    protected $table = 'users';

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
