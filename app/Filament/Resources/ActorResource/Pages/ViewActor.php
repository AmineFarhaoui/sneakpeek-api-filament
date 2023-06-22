<?php

namespace App\Filament\Resources\ActorResource\Pages;

use App\Filament\Resources\ActorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewActor extends ViewRecord
{
    protected static string $resource = ActorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
