<?php

namespace App\Library\Services;

use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LoginAttemptService
{
    /**
     * Create a new login attempt.
     */
    public function create(array $data): LoginAttempt
    {
        return $this->save(new LoginAttempt(), $data);
    }

    /**
     * Create a new login attempt via a request.
     */
    public function createViaRequest(array $data, Request $request): LoginAttempt
    {
        $email = $request->email ?? $data['email'];

        return $this->create($data + [
            'email' => $email,
            'user_id' => User::firstWhere('email', $email)?->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * Save the login attempt to the database.
     */
    public function save(LoginAttempt $loginAttempt, array $data): LoginAttempt
    {
        return tap($loginAttempt->fill($data))->save();
    }

    /**
     * Determine whether the login attempt is suspicious.
     */
    public function isSuspiciousLoginAttempt(LoginAttempt $loginAttempt): bool
    {
        // If the login attempt was not successful, then it's not suspicious.
        if (! $loginAttempt->succesfull) {
            return false;
        }

        $user = $loginAttempt->user;

        // If we don't have a user, or this is the first successful login attempt
        // for the user, then we don't want to return the user.
        if (! $user || $this->hasOnlyOneSuccessfulLoginAttempt($user)) {
            return false;
        }

        // Get all the previous login attempts for the user, excluding the
        // current login attempt.
        $previousAttempts = $this->getSuspiciousLoginAttempts($user, false, $loginAttempt);

        // If the IP address of the current login attempt is not the same as
        // any of the previous login attempts, then we can mark the current
        // login attempt as suspicious. Otherwise, we need to check the user
        // agent to see if it's suspicious. If so, we can mark the current
        // login attempt as suspicious.
        if ($this->isSuspiciousIpAddress($loginAttempt, $previousAttempts)
            || $this->isSuspiciousUserAgent($loginAttempt, $previousAttempts)) {
            $loginAttempt->markAsSuspicious();

            return true;
        }

        return false;
    }

    /**
     * Get all (non)suspicious login attempts for the given user.
     */
    public function getSuspiciousLoginAttempts(
        User $user,
        bool $suspicious = true,
        LoginAttempt $ignore = null,
    ): Collection {
        $query = $user->loginAttempts()
            ->where('suspicious', $suspicious);

        if ($ignore) {
            $query->where('id', '!=', $ignore->id);
        }

        return $query->groupBy(['ip_address', 'user_agent'])
            ->get(['ip_address', 'user_agent']);
    }

    /**
     * Determine if the login attempt is the first successful login attempt for
     * the given user.
     */
    public function hasOnlyOneSuccessfulLoginAttempt(User $user): bool
    {
        return $user->loginAttempts()->where('success', true)->count() === 1;
    }

    /**
     * Determine if the IP address is suspicious.
     */
    public function isSuspiciousIpAddress(
        LoginAttempt $currentAttempt,
        Collection $previousAttempts,
    ): bool {
        return $previousAttempts->doesntContain('ip_address', $currentAttempt->ip_address);
    }

    /**
     * Determine if the user-agent is suspicious.
     */
    public function isSuspiciousUserAgent(
        LoginAttempt $currentAttempt,
        Collection $previousAttempts,
    ): bool {
        return ! $previousAttempts->contains(
            fn ($attempt) => $attempt->user_agent->diff($currentAttempt->user_agent)->count() <= 2
                && $attempt->user_agent['platform'] === $currentAttempt->user_agent['platform'],
        );
    }

    /**
     * Determine if the user has a notifiable role.
     */
    public function userHasNotifiableRole(User|null $user): bool
    {
        $notifiableRoles = config('auth.login_attempts.notify_roles', false);

        // If user has any of the notifiable roles, then we can notify them.
        if (is_array($notifiableRoles) && $user?->hasRole($notifiableRoles)) {
            return true;
        }

        return false;
    }
}
