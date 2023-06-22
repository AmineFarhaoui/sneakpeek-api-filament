<?php

declare(strict_types=1);

namespace App\Library\Enumerations;

use BenSampo\Enum\Enum;

final class ScheduledMessageAlignment extends Enum
{
    const LEADING = 0;

    const TRAILING = 1;

    const CENTER = 2;
}
