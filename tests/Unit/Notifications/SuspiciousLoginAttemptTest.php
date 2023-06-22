<?php

namespace Tests\Unit\Notifications;

use App\Library\Services\IpApiService;
use App\Models\LoginAttempt;
use App\Models\User;
use App\Notifications\SuspiciousLoginNotification;
use Tests\TestCase;

class SuspiciousLoginAttemptTest extends TestCase
{
    /** @test */
    public function it_has_correct_notification_body(): void
    {
        $loginAttempt = LoginAttempt::factory()->create([
            'ip_address' => '8.8.8.8',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
            'user_id' => User::factory(),
        ]);

        $location = (new IpApiService())->getLocationDetails($loginAttempt->ip_address);

        $notification = (new SuspiciousLoginNotification($loginAttempt))->toMail($loginAttempt->user)->render();

        $this->assertStringContainsString('Time: '.$loginAttempt->created_at->format('d/m/Y H:i:s'), $notification);
        $this->assertStringContainsString('Location: '.$location->get('city').', '.$location->get('country'), $notification);
        $this->assertStringContainsString('IP Address: '.$loginAttempt->ip_address, $notification);
        $this->assertStringContainsString('Browser: '.$loginAttempt->user_agent->get('browser').' '.$loginAttempt->user_agent->get('browser_version'), $notification);
        $this->assertStringContainsString('Operating System: '.$loginAttempt->user_agent->get('platform').' '.$loginAttempt->user_agent->get('platform_version'), $notification);
    }
}
