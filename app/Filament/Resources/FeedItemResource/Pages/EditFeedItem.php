<?php

namespace App\Filament\Resources\FeedItemResource\Pages;

use App\Filament\Resources\FeedItemResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeedItem extends EditRecord
{
    protected static string $resource = FeedItemResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
