<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledMessage extends Model
{
    use HasFactory;

    /*
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'conversation_id',
        'show_template_message_id',
        'actor_id',
        'send_at',
        'alignment',
    ];

    /*
     * The conversation that this scheduled message belongs to.
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /*
     * The show template message that this scheduled message belongs to.
     */
    public function showTemplateMessage(): BelongsTo
    {
        return $this->belongsTo(ShowTemplateMessage::class);
    }

    /*
     * The user that this scheduled message belongs to.
     */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(Actor::class);
    }
}
