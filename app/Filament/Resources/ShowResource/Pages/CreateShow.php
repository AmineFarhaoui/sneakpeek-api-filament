<?php

namespace App\Filament\Resources\ShowResource\Pages;

use App\Filament\Resources\ShowResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShow extends CreateRecord
{
    protected static string $resource = ShowResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['introduction_texts'] =
            collect(array_values($data['introduction_texts']))
                ->pluck('text')
                ->toArray();

        return $data;
    }
}
