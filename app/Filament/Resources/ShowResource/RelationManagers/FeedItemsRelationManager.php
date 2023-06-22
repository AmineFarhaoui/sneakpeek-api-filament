<?php

namespace App\Filament\Resources\ShowResource\RelationManagers;

use App\Library\Enumerations\FeedItemType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class FeedItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'feedItems';

    protected static ?string $recordTitleAttribute = 'type';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options(FeedItemType::getValues())
                    ->required(),

                Forms\Components\Toggle::make('has_live_moment')
                    ->required(),

                Forms\Components\Toggle::make('is_coming_soon')
                    ->required(),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                            ->enableOpen()
                            ->collection('cover')
                            ->required(),

                        Forms\Components\SpatieMediaLibraryFileUpload::make('title')
                            ->enableOpen()
                            ->collection('title')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->enum(FeedItemType::getKeys()),

                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover'),

                Tables\Columns\IconColumn::make('has_live_moment')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_coming_soon')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
