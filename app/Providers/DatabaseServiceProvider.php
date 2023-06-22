<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * List all models which should be added to the morph map here.
     */
    protected array $modelsForMorphMap = [
        \App\Models\User::class,
        \App\Models\Show::class,
        \App\Models\Genre::class,
        \App\Models\FeedItem::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->createMorphMap();
    }

    /**
     * Create the morph map from the given models.
     */
    private function createMorphMap(): void
    {
        $morphMap = [];

        foreach ($this->modelsForMorphMap as $key => $model) {
            $key = is_string($key) ? $key : (new $model)->getTable();

            $morphMap[$key] = $model;
        }

        Relation::enforceMorphMap($morphMap);
    }
}
