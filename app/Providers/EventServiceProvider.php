<?php

namespace App\Providers;

use App\Listeners\LockedOutLoginAttempt;
use App\Models\Conversation;
use App\Models\LoginAttempt;
use App\Observers\ConversationObserver;
use App\Observers\LoginAttemptObserver;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Lockout::class => [
            LockedOutLoginAttempt::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        LoginAttempt::observe(LoginAttemptObserver::class);
        Conversation::observe(ConversationObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
