<?php

namespace App\Policies;

use App\Models\AhwcMember;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AhwcMemberPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role=='MO';

    }

    public function viewAnyAll(User $user): bool
    {
        return $user->role === 'ADMIN';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AhwcMember $ahwcMember): bool
    {
        return $user->role=='MO';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role=='MO';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AhwcMember $ahwcMember): bool
    {
        return $user->role=='MO';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AhwcMember $ahwcMember): bool
    {
        return $user->role=='MO';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AhwcMember $ahwcMember): bool
    {
        return $user->role=='MO';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AhwcMember $ahwcMember): bool
    {
        return $user->role=='MO';
    }
}
