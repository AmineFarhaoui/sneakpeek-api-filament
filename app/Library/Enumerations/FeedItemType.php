<?php

declare(strict_types=1);

namespace App\Library\Enumerations;

use BenSampo\Enum\Enum;

final class FeedItemType extends Enum
{
    const DEFAULT = 0;

    const FEATURED = 1;
}
