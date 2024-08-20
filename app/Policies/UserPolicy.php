<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role=='ADMIN';
    }

    public function view(User $user, User $model): bool
    {
        return $user->role=='ADMIN';
    }
}
