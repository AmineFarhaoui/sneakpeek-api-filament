<?php

namespace App\Library\Services;

use App\Library\Enumerations\ScheduledMessageAlignment;
use App\Library\Enumerations\ShowTemplateAlignment;
use App\Models\ShowTemplateMessage;

class ScheduledMessageAlignmentManager
{
    /**
     * Index of the current alignment.
     */
    protected int $alignmentIndex = 0;

    /**
     * The alignment types.
     */
    protected array $alignmentTypes;

    public function __construct(protected ShowTemplateAlignment $showTemplateAlignment)
    {
        $this->alignmentTypes = ScheduledMessageAlignment::getValues();
    }

    /**
     * Get the current alignment type.
     */
    public function getCurrentAlignment(ShowTemplateMessage $showTemplateMessage)
    {
        if ($showTemplateMessage->system_message) {
            return ScheduledMessageAlignment::CENTER;
        }

        return match ($this->showTemplateAlignment->value) {
            ShowTemplateAlignment::FIXED => $showTemplateMessage->actor->alignment,
            ShowTemplateAlignment::ROTATE => $this->alignmentTypes[$this->alignmentIndex],
            default => ScheduledMessageAlignment::LEADING,
        };
    }

    /**
     * Rotate the alignment.
     */
    public function rotateAlignment(): void
    {
        $this->alignmentIndex++;

        if ($this->alignmentIndex > 1) {
            $this->alignmentIndex = 0;
        }
    }
}
