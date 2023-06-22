<?php

namespace App\Listeners;

use App\Library\Enumerations\LoginAttemptLockoutReason;
use App\Library\Services\LoginAttemptService;
use Illuminate\Auth\Events\Lockout;

class LockedOutLoginAttempt
{
    /**
     * Create the event listener.
     */
    public function __construct(protected LoginAttemptService $service)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Lockout $event): void
    {
        $this->service->createViaRequest([
            'success' => false,
            'lockout_reason' => LoginAttemptLockoutReason::TooManyAttempts,
        ], $event->request);
    }
}
