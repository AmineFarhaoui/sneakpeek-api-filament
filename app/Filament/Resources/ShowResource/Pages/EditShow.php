<?php

namespace App\Filament\Resources\ShowResource\Pages;

use App\Filament\Resources\ShowResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShow extends EditRecord
{
    protected static string $resource = ShowResource::class;

    /*
     * Mutate the form data before it is saved to the database.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['introduction_texts'] =
            collect(array_values($data['introduction_texts']))
                ->pluck('text')
                ->toArray();

        return $data;
    }

    /*
     * Mutate the form data before it is filled into the form.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['introduction_texts'] =
            collect($data['introduction_texts'])
                ->map(fn ($text) => ['text' => $text])
                ->toArray();

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
