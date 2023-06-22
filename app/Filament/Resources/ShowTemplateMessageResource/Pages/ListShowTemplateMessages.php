<?php

namespace App\Filament\Resources\ShowTemplateMessageResource\Pages;

use App\Filament\Resources\ShowTemplateMessageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShowTemplateMessages extends ListRecords
{
    protected static string $resource = ShowTemplateMessageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
