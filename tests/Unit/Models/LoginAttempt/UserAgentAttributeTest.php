<?php

namespace Tests\Unit\Models\LoginAttempt;

use App\Models\LoginAttempt;
use Tests\TestCase;

class UserAgentAttributeTest extends TestCase
{
    /** @test */
    public function it_gets_user_agent(): void
    {
        $loginAttempt = LoginAttempt::factory()->createQuietly([
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36',
        ]);

        $userAgent = $loginAttempt->user_agent;

        $this->assertMatchesSnapshot($userAgent->toArray());
    }

    /** @test */
    public function it_sets_user_agent(): void
    {
        $loginAttempt = LoginAttempt::factory()->createQuietly();

        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36';

        $loginAttempt->update([
            'user_agent' => $userAgent,
        ]);

        $this->assertDatabaseHas('login_attempts', [
            'id' => $loginAttempt->id,
            'user_agent' => $userAgent,
        ]);
    }

    /** @test */
    public function it_gets_the_raw_user_agent(): void
    {
        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36';

        $loginAttempt = LoginAttempt::factory()->createQuietly([
            'user_agent' => $userAgent,
        ]);

        $this->assertSame($userAgent, $loginAttempt->raw_user_agent);
    }
}
