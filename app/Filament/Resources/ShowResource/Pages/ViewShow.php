<?php

namespace App\Filament\Resources\ShowResource\Pages;

use App\Filament\Resources\FeedItemResource;
use App\Filament\Resources\ShowResource;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewShow extends ViewRecord
{
    protected static string $resource = ShowResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make('Edit Show'),

            Action::make('Create Feed Item')
                ->action(fn () => redirect(FeedItemResource::getUrl('create'))),
        ];
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
}
