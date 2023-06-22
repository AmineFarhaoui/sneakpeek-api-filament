<?php

namespace App\Filament\Resources\ShowTemplateResource\Pages;

use App\Filament\Actions\ShowTemplateMessage\Import\ShowTemplateMessageImportAction;
use App\Filament\Resources\ShowTemplateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewShowTemplate extends ViewRecord
{
    protected static string $resource = ShowTemplateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            ShowTemplateMessageImportAction::make()
                ->record($this->record), // TODO: Fix this.
        ];
    }
}
