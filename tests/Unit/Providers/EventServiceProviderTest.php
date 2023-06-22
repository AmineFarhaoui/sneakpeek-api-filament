<?php

namespace Tests\Unit\Providers;

use App\Listeners\LockedOutLoginAttempt;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class EventServiceProviderTest extends TestCase
{
    /** @test */
    public function is_listening(): void
    {
        Event::fake();

        $assertions = [
            Lockout::class => LockedOutLoginAttempt::class,
        ];

        foreach ($assertions as $event => $listener) {
            Event::assertListening($event, $listener);
        }
    }
}
