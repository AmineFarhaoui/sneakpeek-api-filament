<?php

namespace Tests\Unit\Models\LoginAttempt;

use App\Models\LoginAttempt;
use Tests\TestCase;

class MarkAsSuspiciousTest extends TestCase
{
    /** @test */
    public function it_marks_login_attempts_suspicious(): void
    {
        $loginAttempt = LoginAttempt::factory()->createQuietly([
            'suspicious' => false,
        ]);

        $loginAttempt->markAsSuspicious();

        $this->assertTrue($loginAttempt->fresh()->suspicious);

        $loginAttempt->markAsSuspicious(false);

        $this->assertFalse($loginAttempt->fresh()->suspicious);
    }
}
