<?php

namespace App\Filament\Resources\ShowTemplateResource\RelationManagers;

use App\Filament\Resources\ActorResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class ShowTemplateMessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'ShowTemplateMessages';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('actor_id')
                    ->relationship('actor', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Toggle::make('system_message')
                    ->required(),

                Forms\Components\TextInput::make('day')
                    ->maxValue(7)
                    ->numeric(),

                Forms\Components\TextInput::make('week')
                    ->maxValue(52)
                    ->numeric(),

                Forms\Components\TimePicker::make('time'),

                Forms\Components\TextInput::make('message')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('actor.name')
                    ->url(fn ($record) => ActorResource::getUrl('view', [$record->actor_id]))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('day'),

                Tables\Columns\TextColumn::make('week'),

                Tables\Columns\TextColumn::make('time')
                    ->Time(),

                Tables\Columns\IconColumn::make('system_message')
                    ->boolean(),

                Tables\Columns\TextColumn::make('message'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
