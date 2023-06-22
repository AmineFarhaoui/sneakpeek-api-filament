<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedItemResource\Pages;
use App\Library\Enumerations\FeedItemType;
use App\Models\FeedItem;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class FeedItemResource extends Resource
{
    protected static ?string $model = FeedItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('show_id')
                    ->relationship('show', 'name')
                    ->required(),

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
                    ])->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('show.name')
                    ->url(fn ($record) => ShowResource::getUrl('view',
                        ['record' => $record->show_id]))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->enum(FeedItemType::getKeys())
                    ->sortable(),

                Tables\Columns\IconColumn::make('has_live_moment')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_coming_soon')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedItems::route('/'),
            'create' => Pages\CreateFeedItem::route('/create'),
            'view' => Pages\ViewFeedItem::route('/{record}'),
            'edit' => Pages\EditFeedItem::route('/{record}/edit'),
        ];
    }
}
