<?php

namespace App\Filament\Resources\ShowTemplateMessageResource\Pages;

use App\Filament\Resources\ShowTemplateMessageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewShowTemplateMessage extends ViewRecord
{
    protected static string $resource = ShowTemplateMessageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
