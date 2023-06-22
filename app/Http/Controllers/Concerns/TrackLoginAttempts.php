<?php

namespace App\Http\Controllers\Concerns;

use Exception;
use Illuminate\Http\Request;

trait TrackLoginAttempts
{
    /**
     * Track a login attempt. Captures any exceptions using Sentry.
     */
    protected function trackLoginAttempt(array $data, Request $request): void
    {
        try {
            $this->loginAttemptService->createViaRequest($data, $request);
        } catch (Exception $e) {
            app('sentry')->captureException($e);
        }
    }
}
