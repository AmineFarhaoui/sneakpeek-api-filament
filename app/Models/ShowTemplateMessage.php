<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShowTemplateMessage extends Model
{
    use HasFactory;

    /*
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'show_template_id',
        'actor_id',
        'system_message',
        'week',
        'day',
        'time',
        'message',
    ];

    /*
     * The belongs to relationship to the show template.
     */
    public function showTemplate(): BelongsTo
    {
        return $this->belongsTo(ShowTemplate::class);
    }

    /*
     * The belongs to relationship to the actor.
     */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(Actor::class);
    }
}
