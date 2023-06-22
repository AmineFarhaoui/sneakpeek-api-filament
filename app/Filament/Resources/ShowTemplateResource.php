<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShowTemplateResource\Pages;
use App\Filament\Resources\ShowTemplateResource\RelationManagers\ShowTemplateMessagesRelationManager;
use App\Library\Enumerations\ShowTemplateAlignment;
use App\Models\ShowTemplate;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ShowTemplateResource extends Resource
{
    protected static ?string $model = ShowTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-template';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('message_alignment')
                    ->options(ShowTemplateAlignment::getKeys())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                // TODO: Should be TextColumn
                Tables\Columns\SelectColumn::make('message_alignment')
                    ->options(ShowTemplateAlignment::getKeys())
                    ->disabled(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
            ShowTemplateMessagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShowTemplates::route('/'),
            'create' => Pages\CreateShowTemplate::route('/create'),
            'view' => Pages\ViewShowTemplate::route('/{record}'),
            'edit' => Pages\EditShowTemplate::route('/{record}/edit'),
        ];
    }
}
