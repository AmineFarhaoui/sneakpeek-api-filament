<?php

namespace Tests\Feature\Nova\Auth;

use App\Library\Enumerations\LoginAttemptLockoutReason;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function it_logs_in_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/admin/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('login_attempts', [
            'email' => $user->email,
            'success' => true,
            'lockout_reason' => null,
        ]);
    }

    /** @test */
    public function it_doesnt_log_in_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/admin/login', [
            'email' => $user->email,
            'password' => 'Secret1?',
        ]);

        $response->assertStatus(422);

        $this->assertDatabaseHas('login_attempts', [
            'email' => $user->email,
            'success' => false,
            'lockout_reason' => LoginAttemptLockoutReason::InvalidCredentials,
        ]);
    }
}
