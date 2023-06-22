<?php

namespace App\Filament\Resources\ShowTemplateMessageResource\Pages;

use App\Filament\Resources\ShowTemplateMessageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShowTemplateMessage extends EditRecord
{
    protected static string $resource = ShowTemplateMessageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
