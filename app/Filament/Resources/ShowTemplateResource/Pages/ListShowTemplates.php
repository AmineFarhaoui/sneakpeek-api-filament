<?php

namespace App\Filament\Resources\ShowTemplateResource\Pages;

use App\Filament\Resources\ShowTemplateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShowTemplates extends ListRecords
{
    protected static string $resource = ShowTemplateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
