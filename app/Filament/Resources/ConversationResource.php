<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConversationResource\Pages;
use App\Models\Conversation;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ConversationResource extends Resource
{
    protected static ?string $model = Conversation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('show_id')
                    ->relationship('show', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('show_template_id')
                    ->relationship('showTemplate', 'name')
                    ->searchable()
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
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('show.name')
                    ->url(fn ($record) => ShowResource::getUrl('view', [$record->show]))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('showTemplate.name')
                    ->url(fn ($record) => ShowTemplateResource::getUrl('view', [$record->show_template_id])),

                Tables\Columns\TextColumn::make('external_url'),

                Tables\Columns\TextColumn::make('starting_date')
                    ->sortable()
                    ->dateTime(),

                Tables\Columns\IconColumn::make('is_preview')
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConversations::route('/'),
            'create' => Pages\CreateConversation::route('/create'),
            'view' => Pages\ViewConversation::route('/{record}'),
            'edit' => Pages\EditConversation::route('/{record}/edit'),
        ];
    }
}
