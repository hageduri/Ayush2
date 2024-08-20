<?php

namespace App\Policies;

use App\Models\User;

class AllUsersPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role=='SUPER';
    }

    public function view(User $user, User $model): bool
    {
        return $user->role=='SUPER';
    }

    public function create(User $user): bool
    {
        return $user->role=='SUPER';
    }

    public function update(User $user, User $model): bool
    {
        return $user->role=='SUPER';
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role=='SUPER';
    }
}
