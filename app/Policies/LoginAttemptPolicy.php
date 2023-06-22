<?php

namespace App\Policies;

use App\Models\LoginAttempt;
use App\Models\User;

class LoginAttemptPolicy extends Policy
{
    /**
     * Abilities which admin should not be auto-allowed to do.
     */
    protected array $disallowAdmin = [
        'create',
        'update',
        'delete',
    ];

    /**
     * Determine whether the user can view any users.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the login attempt.
     */
    public function view(User $user, LoginAttempt $loginAttempt): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create users.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the login attempt.
     */
    public function update(User $user, LoginAttempt $loginAttempt): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the login attempt.
     */
    public function delete(User $user, LoginAttempt $loginAttempt): bool
    {
        return false;
    }
}
