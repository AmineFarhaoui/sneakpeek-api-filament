<?php

namespace Tests\Feature\Auth;

use App\Library\Enumerations\LoginAttemptLockoutReason;
use App\Library\Services\LoginAttemptService;
use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * The password used to create a user and login.
     *
     * @var string
     */
    private $password = 'Password1!';

    /** @test */
    public function can_login(): void
    {
        [$user] = $this->prepare();

        $this->mockLoginAttemptService();

        $data = $this->requestData($user);

        $response = $this->makeRequest($data);

        $this->assertResponse($response);

        $this->assertToken($user, $response->json()['apiToken']);
    }

    /** @test */
    public function cannot_login(): void
    {
        [$user] = $this->prepare();

        $this->mockLoginAttemptService(LoginAttemptLockoutReason::InvalidCredentials);

        $data = $this->requestData($user);

        // Change password.
        $data['password'] = strrev($data['password']);

        $response = $this->makeRequest($data);

        $this->assertResponse($response, 401);
    }

    /** @test */
    public function login_throttles(): void
    {
        [$user] = $this->prepare();

        $data = $this->requestData($user);

        // Change password.
        $data['password'] = strrev($data['password']);

        // Request to login with an incorrect password the max amount of times
        // configured.
        for ($i = 0; $i < config('auth.login_throttle_max_attempts'); $i++) {
            $response = $this->makeRequest($data);

            $this->assertResponse($response, 401);
        }

        Event::fake([Lockout::class]);

        $response = $this->makeRequest($data);

        $this->assertResponse($response, 429);

        Event::assertDispatched(Lockout::class);
    }

    /**
     * Prepares for tests.
     */
    private function prepare(): array
    {
        $user = User::factory()->create([
            'password' => Hash::make($this->password),
        ]);

        return [$user];
    }

    /**
     * Mocks the login attempt service. If the reason is null, we assume the
     * login attempt was successful.
     */
    private function mockLoginAttemptService(
        LoginAttemptLockoutReason $reason = null,
    ): void {
        $this->mock(LoginAttemptService::class)
            ->expects('createViaRequest')
            ->with([
                'success' => $reason === null,
                'lockout_reason' => $reason,
            ], \Mockery::any())
            ->andReturn(new LoginAttempt());
    }

    /**
     * Returns data used in a request.
     */
    private function requestData(User $user): array
    {
        return [
            'email' => $user->email,
            'password' => $this->password,
        ];
    }

    /**
     * Makes a request.
     */
    private function makeRequest(array $data): TestResponse
    {
        return $this->json('POST', 'auth/login', $data);
    }

    /**
     * Asserts a response.
     */
    private function assertResponse(TestResponse $response, int $status = 200): void
    {
        $response->assertStatus($status);

        if ($status !== 200) {
            return;
        }

        $this->assertJsonStructureSnapshot($response);
    }

    /**
     * Asserts a token that has been returned from the request.
     */
    private function assertToken(User $user, string $token): void
    {
        $auth = Auth::setToken($token);

        $this->assertEquals(
            $user->id,
            $auth->user()->id,
            'The token does not belong to the user.',
        );
    }
}
