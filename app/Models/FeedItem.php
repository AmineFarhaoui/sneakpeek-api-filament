<?php

namespace App\Models;

use App\Models\Concerns\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FeedItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'type', 'show_id', 'has_live_moment', 'is_coming_soon',
    ];

    /**
     * Get the show for the FeedItem.
     */
    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    /**
     * Register the media conversions.
     */
    public function registerMediaCollections(): void
    {
        $collections = [
            'cover', 'title',
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
        $coverSizes = [210 => 210, 1100 => 175];

        foreach ($coverSizes as $width => $height) {
            $this->addMediaConversion($width)
                ->performOnCollections('cover')
                ->fit(Manipulations::FIT_CONTAIN, $width, $height);
        }

        $titleSizes = [120 => 120, 210 => 210];

        foreach ($titleSizes as $width => $height) {
            $this->addMediaConversion($width)
                ->performOnCollections('title')
                ->fit(Manipulations::FIT_CONTAIN, $width, $height);
        }
    }
}
