<?php

namespace App\Library\Enumerations;

enum LoginAttemptLockoutReason: int
{
    case InvalidCredentials = 0;
    case TooManyAttempts = 1;
}
