<?php

namespace App\Models;

use App\Models\Concerns\HasFullName;
use App\Models\Concerns\InteractsWithMedia;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\ResetPasswordNotification;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContact;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanResetPasswordContact, HasMedia, JWTSubject, MustVerifyEmail, HasName, HasAvatar
{
    use CanResetPassword, HasFactory, HasRoles, InteractsWithMedia, Notifiable, HasFullName;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'email', 'password', 'email_verified_at', 'first_name', 'last_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The name of the guard that is being for the roles.
     *
     * @var string
     */
    public $guard_name = 'api';

    /**
     * Get the login attempts for the user.
     */
    public function loginAttempts(): HasMany
    {
        return $this->hasMany(LoginAttempt::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to
     * the JWT.
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value, $field = null): Model
    {
        if ($value === 'me') {
            // Check if the user has been authenticated.
            if (! current_user() instanceof self) {
                return abort(401);
            }

            return current_user();
        }

        return self::findOrFail($value);
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new EmailVerificationNotification);
    }

    /**
     * {@inheritdoc}
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')
            ->singleFile();
    }

    /**
     * {@inheritdoc}
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addDefaultMediaConversions('profile_picture');
    }

    /**
     * Get the name that will be used in Filament.
     */
    public function getFilamentName(): string
    {
        return $this->full_name;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getFirstMediaUrl('profile_picture');
    }
}
