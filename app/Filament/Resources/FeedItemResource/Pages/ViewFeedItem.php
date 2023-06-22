<?php

namespace App\Filament\Resources\FeedItemResource\Pages;

use App\Filament\Resources\FeedItemResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFeedItem extends ViewRecord
{
    protected static string $resource = FeedItemResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
