<?php

namespace App\Models;

use App\Library\Enumerations\LoginAttemptLockoutReason;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Jenssegers\Agent\Agent;

class LoginAttempt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'email',
        'user_id',
        'ip_address',
        'user_agent',
        'success',
        'suspicious',
        'lockout_reason',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'success' => 'boolean',
        'suspicious' => 'boolean',
        'lockout_reason' => LoginAttemptLockoutReason::class,
    ];

    /**
     * Get the user that belongs to the login attempt.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user agent attribute.
     */
    public function userAgent(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getParsedUserAgentAttribute(),
        );
    }

    /**
     * Get the parsed user agent. Parse it into a collection.
     */
    public function getParsedUserAgentAttribute(): Collection
    {
        $agent = new Agent();
        $agent->setUserAgent($this->attributes['user_agent']);

        return collect([
            'device' => $agent->device(),
            'platform' => $platform = $agent->platform(),
            'platform_version' => $agent->version($platform),
            'browser' => $browser = $agent->browser(),
            'browser_version' => $agent->version($browser),
        ]);
    }

    /**
     * Get the raw user agent attribute.
     */
    public function getRawUserAgentAttribute(): string
    {
        return $this->attributes['user_agent'];
    }

    /**
     * Mark the login attempt as suspicious.
     */
    public function markAsSuspicious(bool $suspicious = true): self
    {
        return tap($this)->update(compact('suspicious'));
    }
}
