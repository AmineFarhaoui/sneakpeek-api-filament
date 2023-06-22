<?php

namespace App\Library\Services;

use App\Models\Actor;
use Illuminate\Database\Eloquent\Model;

class ShowTemplateMessageService
{
    // TODO: Delete this class.
    /*
     * Save a ShowTemplateMessage.
     */
    public function save(array $data, Model $showTemplate): void
    {
        $showTemplate->showTemplateMessages()->Create([
            'actor_id' => $data['actor'] ? Actor::firstOrCreate(['name' => $data['actor']])->id : null,
            'show_template_id' => $showTemplate->id,
            'system_message' => $data['system_message'] ?? false,
            'week' => $data['week'],
            'day' => $data['day'],
            'time' => $data['time'],
            'message' => $data['message'],
        ]);
    }

    /*
     * Save many ShowTemplateMessages.
     */
    public function saveMany(array $data, Model $showTemplate): void
    {
        foreach ($data as $message) {
            $this->save($message, $showTemplate);
        }
    }
}
