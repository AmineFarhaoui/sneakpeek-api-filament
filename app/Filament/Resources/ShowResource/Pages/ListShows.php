<?php

namespace App\Filament\Resources\ShowResource\Pages;

use App\Filament\Resources\ShowResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\SelectFilter;

class ListShows extends ListRecords
{
    protected static string $resource = ShowResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('genre')
                ->searchable()
                ->multiple()
                ->placeholder('All Genres')
                ->relationship('genre', 'name'),
        ];
    }
}
