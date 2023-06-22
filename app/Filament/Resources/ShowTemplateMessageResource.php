<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShowTemplateMessageResource\Pages;
use App\Models\ShowTemplateMessage;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ShowTemplateMessageResource extends Resource
{
    protected static ?string $model = ShowTemplateMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-alt-2';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('show_template_id')
                    ->relationship('showTemplate', 'name')
                    ->required(),

                Forms\Components\Select::make('actor_id')
                    ->relationship('actor', 'name')
                    ->required(),

                Forms\Components\Toggle::make('system_message')
                    ->required(),

                Forms\Components\TextInput::make('day')
                    ->numeric()
                    ->maxValue(7)
                    ->required(),

                Forms\Components\TextInput::make('week')
                    ->numeric()
                    ->maxValue(52)
                    ->required(),

                Forms\Components\TimePicker::make('time')
                    ->required(),

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

                Tables\Columns\TextColumn::make('showTemplate.name')
                    ->url(fn ($record) => ShowTemplateResource::getUrl('view', [$record->show_template_id]))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('actor.name')
                   // ->url(fn ($record) => ActorResource::getUrl('view', [$record->actor_id]))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('day'),

                Tables\Columns\TextColumn::make('week'),

                Tables\Columns\TextColumn::make('time')
                    ->time(),

                Tables\Columns\TextColumn::make('message'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),

            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShowTemplateMessages::route('/'),
            'create' => Pages\CreateShowTemplateMessage::route('/create'),
            'view' => Pages\ViewShowTemplateMessage::route('/{record}'),
            'edit' => Pages\EditShowTemplateMessage::route('/{record}/edit'),
        ];
    }
}
