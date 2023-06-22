<?php

namespace App\Observers;

use App\Library\Services\LoginAttemptService;
use App\Models\LoginAttempt;
use App\Notifications\SuspiciousLoginNotification;

class LoginAttemptObserver
{
    /**
     * Create a new login attempt observer.
     */
    public function __construct(protected LoginAttemptService $service)
    {
        //
    }

    /**
     * Determine whether the login attempt is suspicious and send a notification if it is.
     */
    public function created(LoginAttempt $loginAttempt): void
    {
        if ($this->service->isSuspiciousLoginAttempt($loginAttempt)
            && $this->service->userHasNotifiableRole($loginAttempt->user)) {
            $loginAttempt->user->notify(new SuspiciousLoginNotification($loginAttempt));
        }
    }
}
