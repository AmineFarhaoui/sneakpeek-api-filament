<?php

namespace Tests\Unit\Observers;

use App\Library\Services\LoginAttemptService;
use App\Models\LoginAttempt;
use App\Models\User;
use App\Notifications\SuspiciousLoginNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class LoginAttemptObserverTest extends TestCase
{
    /** @test */
    public function it_notifies_users_on_suspicious_logins(): void
    {
        $mock = $this->mock(LoginAttemptService::class);

        $mock->expects('isSuspiciousLoginAttempt')
            ->andReturnTrue();

        $mock->expects('userHasNotifiableRole')
            ->andReturnTrue();

        $loginAttempt = LoginAttempt::factory()->create([
            'user_id' => User::factory(),
        ]);

        Notification::assertSentTo($loginAttempt->user, SuspiciousLoginNotification::class);
    }

    /** @test */
    public function it_doesnt_notify_users_on_none_suspicious_logins(): void
    {
        $this->mock(LoginAttemptService::class)
            ->expects('isSuspiciousLoginAttempt')
            ->andReturnFalse();

        $loginAttempt = LoginAttempt::factory()->create([
            'user_id' => User::factory(),
        ]);

        Notification::assertNothingSentTo($loginAttempt->user);
    }

    /** @test */
    public function it_sends_notifications_to_user_with_notifiable_role_on_suspicious_login(): void
    {
        $mock = $this->mock(LoginAttemptService::class);

        $mock->expects('isSuspiciousLoginAttempt')
            ->andReturnTrue();

        $mock->expects('userHasNotifiableRole')
            ->andReturnTrue();

        $loginAttempt = LoginAttempt::factory()->create([
            'user_id' => User::factory(),
            'suspicious' => true,
        ]);

        Notification::assertSentTo($loginAttempt->user, SuspiciousLoginNotification::class);
    }

    /** @test */
    public function it_doesnt_send_notifications_to_user_without_notifiable_role_on_suspicious_login(): void
    {
        $mock = $this->mock(LoginAttemptService::class);

        $mock->expects('isSuspiciousLoginAttempt')
            ->andReturnTrue();

        $mock->expects('userHasNotifiableRole')
            ->andReturnFalse();

        $user = User::factory()->create();

        $loginAttempt = LoginAttempt::factory()->create([
            'user_id' => $user,
        ]);

        Notification::assertNothingSentTo($loginAttempt->user);
    }
}
