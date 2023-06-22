<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\SuspiciousLoginNotification;
use Illuminate\Support\Str;

class PreviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $email)
    {
        $method = Str::camel($email);

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        abort(404);
    }

    /**
     * The email verification preview.
     */
    private function suspiciousLoginAttempt(): string
    {
        $user = User::first();

        $loginAttempt = $user->loginAttempts()->create([
            'email' => $user->email,
            'ip_address' => '143.178.17.39',
            'user_agent' => request()->userAgent(),
        ]);

        $notification = new SuspiciousLoginNotification($loginAttempt);

        return $notification->toMail($user)->render();
    }

    /**
     * The email verification preview.
     */
    private function emailVerification(): string
    {
        $user = User::first();

        $notification = new EmailVerificationNotification;

        return $notification->toMail($user)->render();
    }

    /**
     * The reset password preview.
     */
    private function resetPassword(): string
    {
        $user = User::first();

        $notification = new ResetPasswordNotification('some_token');

        return $notification->toMail($user)->render();
    }
}
