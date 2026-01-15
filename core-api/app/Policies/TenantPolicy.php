<?php

namespace App\Policies;

use App\Models\Tenant\TenantUser;

class TenantPolicy
{
    public function access(TenantUser $user, string $requiredRole): bool
    {
        return $user->role === $requiredRole || $user->role === 'admin';
    }
}
