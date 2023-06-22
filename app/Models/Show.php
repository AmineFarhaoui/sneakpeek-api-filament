<?php

namespace App\Models;

use App\Models\Concerns\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Show extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'slug', 'introduction_texts', 'share_text', 'share_url',
        'external_group_url', 'description', 'in_app_description',
        'footer_note', 'price', 'transaction_costs', 'cast', 'creators',
        'production', 'allows_in_app_registration',
        'allows_external_registration', 'ios_reference', 'preview_token',
        'gua_id', 'ga4_id', 'gtm_id',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'introduction_texts' => 'array',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the conversations for the Show.
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * Get the genre for the Show.
     */
    public function genre(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_show');
    }

    /**
     * Get the FeedItems for the Show.
     */
    public function feedItems(): HasMany
    {
        return $this->hasMany(FeedItem::class);
    }

    /**
     * Register the media collections.
     */
    public function registerMediaCollections(): void
    {
        $collections = [
            'icon', 'heading', 'heading_title', 'trailer', 'trailer_backup',
        ];

        foreach ($collections as $collection) {
            $this->addMediaCollection($collection)
                ->singleFile();
        }
    }

    /**
     * Register the media conversions.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->extractVideoFrameAtSecond(1)
            ->performOnCollections('trailer');

        $iconSizes = [120 => 120, 210 => 210];

        foreach ($iconSizes as $width => $height) {
            $this->addMediaConversion($width)
                ->performOnCollections('icon')
                ->fit(Manipulations::FIT_CROP, $width, $height);
        }
    }
}
