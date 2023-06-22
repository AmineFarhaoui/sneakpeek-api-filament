<?php

namespace Tests\Unit\Library\Services;

use App\Library\Enumerations\Role;
use App\Library\Services\LoginAttemptService;
use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Http\Request;
use Tests\TestCase;

class LoginAttemptServiceTest extends TestCase
{
    protected string $ip = '192.168.0.0';

    protected string $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36';

    /** @test */
    public function it_creates(): void
    {
        $data = [
            'email' => 'dees@owow.io',
            'ip_address' => $this->ip,
            'user_agent' => $this->userAgent,
            'success' => true,
        ];

        $loginAttempt = $this->app->make(LoginAttemptService::class)->create($data);

        $this->assertDatabaseHas('login_attempts', $data + [
            'id' => $loginAttempt->id,
        ]);
    }

    /** @test */
    public function it_creates_using_request(): void
    {
        $data = [
            'success' => false,
        ];

        $request = $this->mock(Request::class);
        $request->email = 'dees@owow.io';
        $request->expects('ip')->andReturn($this->ip);
        $request->expects('userAgent')->andReturn($this->userAgent);

        $loginAttempt = $this->app->make(LoginAttemptService::class)->createViaRequest($data, $request);

        $this->assertDatabaseHas('login_attempts', [
            'id' => $loginAttempt->id,
            'email' => 'dees@owow.io',
            'ip_address' => $this->ip,
            'user_agent' => $this->userAgent,
            'success' => false,
        ]);
    }

    /** @test */
    public function it_saves(): void
    {
        $user = User::factory()->create();

        $data = [
            'email' => 'dees@owow.io',
            'user_id' => $user->id,
            'ip_address' => $this->ip,
            'user_agent' => $this->userAgent,
            'success' => true,
        ];

        $loginAttempt = LoginAttempt::factory()->create([
            'email' => $data['email'],
            'user_id' => $data['user_id'],
        ]);

        $this->app->make(LoginAttemptService::class)
            ->save($loginAttempt, $data);

        $this->assertDatabaseHas('login_attempts', $data + [
            'id' => $loginAttempt->id,
        ]);
    }

    /** @test */
    public function it_gets_suspicious_or_non_suspicious_login_attempts(): void
    {
        $user = User::factory()->create();

        LoginAttempt::factory()
            ->count(3)
            ->createQuietly([
                'user_id' => $user->id,
                'user_agent' => $this->userAgent,
                'suspicious' => true,
            ]);

        LoginAttempt::factory()
            ->count(3)
            ->createQuietly([
                'user_id' => $user->id,
                'user_agent' => $this->userAgent,
                'suspicious' => false,
            ]);

        $suspiciousLoginAttempts = $this->app->make(LoginAttemptService::class)
            ->getSuspiciousLoginAttempts($user);

        $nonSuspiciousLoginAttempts = $this->app->make(LoginAttemptService::class)
            ->getSuspiciousLoginAttempts($user, false);

        $this->assertJsonStructureSnapshot($suspiciousLoginAttempts);
        $this->assertJsonStructureSnapshot($nonSuspiciousLoginAttempts);
    }

    /** @test */
    public function checks_if_is_first_successfull_login_attempt(): void
    {
        $user = User::factory()->create();

        LoginAttempt::factory()
            ->createQuietly([
                'user_id' => $user->id,
                'success' => true,
            ]);

        $this->assertTrue(
            $this->app->make(LoginAttemptService::class)
                ->hasOnlyOneSuccessfulLoginAttempt($user),
        );

        LoginAttempt::factory()->createQuietly([
            'user_id' => $user->id,
            'success' => true,
        ]);

        $this->assertFalse(
            $this->app->make(LoginAttemptService::class)
                ->hasOnlyOneSuccessfulLoginAttempt($user),
        );
    }

    /** @test */
    public function it_knows_suspicious_ip_addresses(): void
    {
        $user = User::factory()->create();

        $suspiciousAttempt = LoginAttempt::factory()->createQuietly([
            'user_id' => $user->id,
            'ip_address' => '123.123.123',
        ]);

        $nonSuspiciousAttempt = LoginAttempt::factory()->createQuietly([
            'user_id' => $user->id,
            'ip_address' => $this->ip,
        ]);

        $previousLoginAttempts = LoginAttempt::factory()
            ->count(3)
            ->createQuietly([
                'user_id' => $user->id,
                'ip_address' => $this->ip,
                'suspicious' => false,
            ]);

        $this->assertTrue(
            $this->app->make(LoginAttemptService::class)
                ->isSuspiciousIpAddress($suspiciousAttempt, $previousLoginAttempts),
        );

        $this->assertFalse(
            $this->app->make(LoginAttemptService::class)
                ->isSuspiciousIpAddress($nonSuspiciousAttempt, $previousLoginAttempts),
        );
    }

    /** @test */
    public function it_knows_suspicious_user_agents(): void
    {
        $user = User::factory()->create();

        $loginAttempts = LoginAttempt::factory()
            ->state(new Sequence(
                ['user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36'],
                ['user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.3 Safari/605.1.15'],
                ['user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Firefox/111.0'],
            ))
            ->count(3)
            ->createQuietly([
                'user_id' => $user->id,
            ]);

        $this->assertFalse(
            $this->app->make(LoginAttemptService::class)
                ->isSuspiciousUserAgent($loginAttempts->pop(), $loginAttempts),
        );

        // Add one attempt where the Windows version and browser are different.
        $suspiciousLoginAttempt = LoginAttempt::factory()->createQuietly([
            'user_id' => $user->id,
            'user_agent' => 'Mozilla/5.0 (Windows NT 8.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Firefox/112.0',
        ]);

        $this->assertTrue(
            $this->app->make(LoginAttemptService::class)
                ->isSuspiciousUserAgent($suspiciousLoginAttempt, $loginAttempts),
        );

        // Add one attempt where the platform is different.
        $suspiciousLoginAttempt = LoginAttempt::factory()->createQuietly([
            'user_id' => $user->id,
            'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
        ]);

        $this->assertTrue(
            $this->app->make(LoginAttemptService::class)
                ->isSuspiciousUserAgent($suspiciousLoginAttempt, $loginAttempts),
        );
    }

    /** @test */
    public function user_has_notifiable_roles(): void
    {
        $user = null;

        $service = $this->app->make(LoginAttemptService::class);

        $this->assertFalse($service->userHasNotifiableRole($user));

        $user = User::factory()->create();

        config(['auth.login_attempts.notify_roles' => null]);

        $this->assertFalse($service->userHasNotifiableRole($user));

        config(['auth.login_attempts.notify_roles' => [Role::ADMIN]]);

        $this->assertFalse($service->userHasNotifiableRole($user));

        $user->assignRole(Role::ADMIN);

        $this->assertTrue($service->userHasNotifiableRole($user));
    }

    /**
     * Prepare for tests.
     */
    public function prepare(): array
    {
        $user = User::factory()->create();

        return [
            'email' => $user->email,
            'user_id' => $user->id,
            'ip_address' => $this->ip,
            'user_agent' => $this->userAgent,
            'success' => true,
        ];
    }
}
