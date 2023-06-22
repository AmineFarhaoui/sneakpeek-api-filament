<?php

namespace App\Filament\Resources\ShowResource\RelationManagers;

use App\Filament\Resources\ShowTemplateResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class ConversationRelationManager extends RelationManager
{
    protected static string $relationship = 'Conversations';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('show_template_id')
                    ->relationship('showTemplate', 'name')
                    ->required(),

                Forms\Components\TextInput::make('external_url')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DateTimePicker::make('starting_date')
                    ->required(),

                Forms\Components\Toggle::make('is_preview')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),

                Tables\Columns\TextColumn::make('showTemplate.name')
                    ->url(fn ($record) => ShowTemplateResource::getUrl('view',
                        ['record' => $record->show_template_id]))
                    ->sortable(),

                Tables\Columns\TextColumn::make('starting_date')
                    ->dateTime(),

                Tables\Columns\IconColumn::make('is_preview')
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
