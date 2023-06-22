<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    /*
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'show_id',
        'show_template_id',
        'external_url',
        'starting_date',
        'is_preview',
    ];

    /*
     * The show that this conversation belongs to.
     */
    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    /*
     * Get show template for this conversation.
     */
    public function showTemplate(): BelongsTo
    {
        return $this->belongsTo(ShowTemplate::class);
    }

    /*
     * Get scheduled messages for this conversation.
     */
    public function scheduledMessages(): HasMany
    {
        return $this->hasMany(ScheduledMessage::class);
    }
}
