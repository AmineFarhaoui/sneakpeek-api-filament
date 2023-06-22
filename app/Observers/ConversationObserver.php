<?php

namespace App\Observers;

use App\Library\Services\ScheduledMessageAlignmentManager;
use App\Models\Conversation;

class ConversationObserver
{
    /**
     * Handle the Conversation "created" event.
     */
    public function created(Conversation $conversation): void
    {
        // Get all the show template messages for this conversation.
        $showTemplateMessages = $conversation->showTemplate->showTemplateMessages;

        // If there are no show template messages, we don't need to do anything.
        if ($showTemplateMessages->count() < 1) {
            return;
        }

        $showTemplateAlignment = $conversation->showTemplate->message_alignment;

        $alignmentManager = new ScheduledMessageAlignmentManager($showTemplateAlignment);

        $latestActor = $showTemplateMessages->first()->actor_id;

        // Create a scheduled message for each show template message.
        $showTemplateMessages->each(function ($showTemplateMessage) use (&$latestActor, $alignmentManager, $conversation) {
            if ($showTemplateMessage->actor_id !== $latestActor
                && ! $showTemplateMessage->system_message) {
                $latestActor = $showTemplateMessage->actor_id;

                $alignmentManager->rotateAlignment();
            }

            $conversation->scheduledMessages()->updateOrCreate([
                'show_template_message_id' => $showTemplateMessage->id,
            ], [
                'actor_id' => $showTemplateMessage->actor_id,
                'send_at' => now(),
                'alignment' => $alignmentManager->getCurrentAlignment($showTemplateMessage),
            ]);
        });
    }

    /**
     * Handle the Conversation "updated" event.
     */
    public function updated(Conversation $conversation): void
    {
        //
    }

    /**
     * Handle the Conversation "deleted" event.
     */
    public function deleted(Conversation $conversation): void
    {
        //
    }

    /**
     * Handle the Conversation "restored" event.
     */
    public function restored(Conversation $conversation): void
    {
        //
    }

    /**
     * Handle the Conversation "force deleted" event.
     */
    public function forceDeleted(Conversation $conversation): void
    {
        //
    }
}
