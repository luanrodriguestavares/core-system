<?php

namespace App\Policies;

use App\Models\Master\MasterUser;

class MasterPolicy
{
    public function access(MasterUser $user, string $requiredRole): bool
    {
        return $user->role === $requiredRole || $user->role === 'super_admin';
    }
}
