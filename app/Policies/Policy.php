<?php

namespace App\Policies;

use App\Library\Enumerations\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class Policy
{
    use HandlesAuthorization;

    /**
     * Abilities which admin should not be auto-allowed to do.
     */
    protected array $disallowAdmin = [];

    /**
     * Check if the user has special privileges.
     *
     * @return bool|void
     */
    public function before(User $user, string $ability)
    {
        if (in_array($ability, $this->disallowAdmin)) {
            return;
        }

        if ($user?->hasRole(Role::ADMIN)) {
            return true;
        }
    }
}
