<?php

namespace Tests\Unit\Listeners;

use App\Library\Enumerations\LoginAttemptLockoutReason;
use App\Library\Services\LoginAttemptService;
use App\Listeners\LockedOutLoginAttempt;
use Illuminate\Auth\Events\Lockout;
use Tests\TestCase;

class LockedOutLoginAttemptTest extends TestCase
{
    /** @test */
    public function it_tracks_too_many_attempts(): void
    {
        $this->mock(LoginAttemptService::class)
            ->expects('createViaRequest')
            ->once()
            ->with([
                'success' => false,
                'lockout_reason' => LoginAttemptLockoutReason::TooManyAttempts,
            ], request());

        $listener = $this->app->make(LockedOutLoginAttempt::class);

        $listener->handle(new Lockout(request()));
    }
}
