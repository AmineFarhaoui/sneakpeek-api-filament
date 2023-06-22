<?php

namespace App\Models;

use App\Library\Enumerations\ShowTemplateAlignment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShowTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'message_alignment',
    ];

    /*
     * The attributes that should be cast.
     */
    protected $casts = [
        'message_alignment' => ShowTemplateAlignment::class,
    ];

    /*
     * The has many relationship to show template messages.
     */
    public function showTemplateMessages(): HasMany
    {
        return $this->hasMany(ShowTemplateMessage::class);
    }
}
