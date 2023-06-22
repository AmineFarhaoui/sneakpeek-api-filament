<?php

namespace App\Filament\Resources\ShowTemplateResource\Pages;

use App\Filament\Resources\ShowTemplateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShowTemplate extends EditRecord
{
    protected static string $resource = ShowTemplateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
