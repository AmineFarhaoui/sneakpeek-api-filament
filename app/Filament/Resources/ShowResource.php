<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShowResource\Pages;
use App\Filament\Resources\ShowResource\RelationManagers\ConversationRelationManager;
use App\Filament\Resources\ShowResource\RelationManagers\FeedItemsRelationManager;
use App\Models\Show;
use Filament\Forms;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ShowResource extends Resource
{
    protected static ?string $model = Show::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('General')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('genre')
                                    ->relationship('genre', 'name')
                                    ->multiple()
                                    ->columnSpanFull(),

                                Forms\Components\Toggle::make('allows_in_app_registration')
                                    ->required(),
                            ])->columnSpan(2),

                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\MarkdownEditor::make('description')
                                    ->nullable()
                                    ->maxLength(10000),

                                Forms\Components\MarkdownEditor::make('in_app_description')
                                    ->nullable()
                                    ->maxLength(10000),

                                Forms\Components\MarkdownEditor::make('footer_note')
                                    ->nullable()
                                    ->maxLength(10000),

                                Forms\Components\Repeater::make('introduction_texts')
                                    ->schema([
                                        Forms\Components\TextInput::make('text')
                                            ->label('')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                            ])->columnSpan(3),
                    ])->columns(5)->columnSpan(2),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make('Pricing')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->mask(fn (Mask $mask) => $mask
                                        ->patternBlocks([
                                            'money' => fn (Mask $mask) => $mask
                                                ->numeric()
                                                ->thousandsSeparator('.')
                                                ->decimalSeparator(','),
                                        ])
                                        ->pattern('$money'),
                                    )
                                    ->numeric()
                                    ->nullable(),

                                Forms\Components\TextInput::make('transaction_costs')
                                    ->mask(fn (Mask $mask) => $mask
                                        ->patternBlocks([
                                            'money' => fn (Mask $mask) => $mask
                                                ->numeric()
                                                ->thousandsSeparator('.')
                                                ->decimalSeparator(','),
                                        ])
                                        ->pattern('$money'),
                                    )
                                    ->numeric()
                                    ->nullable(),
                            ])->collapsed(),

                        Forms\Components\Section::make('Other')
                            ->schema([
                                Forms\Components\TextInput::make('ios_reference')
                                    ->nullable()
                                    ->maxLength(255),
                            ])->collapsed(),
                    ])->columnSpan(1),

                Forms\Components\Section::make('Creation Team ')
                    ->schema([
                        Forms\Components\TextInput::make('cast')
                            ->nullable()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('creators')
                            ->nullable()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('production')
                            ->nullable()
                            ->maxLength(255),
                    ])->columnSpan(1)->collapsed(),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('icon')
                            ->collection('icon')
                            ->acceptedFileTypes(['png', 'jpg', 'jpeg', 'webp'])
                            ->maxSize(5120)
                            ->enableOpen(),

                        Forms\Components\SpatieMediaLibraryFileUpload::make('heading')
                            ->collection('heading')
                            ->acceptedFileTypes(['png', 'jpg', 'jpeg', 'webp'])
                            ->maxSize(5120)
                            ->enableOpen(),

                        Forms\Components\SpatieMediaLibraryFileUpload::make('heading_title')
                            ->collection('heading_title')
                            ->acceptedFileTypes(['png', 'jpg', 'jpeg', 'webp'])
                            ->maxSize(5120)
                            ->enableOpen(),

                        Forms\Components\SpatieMediaLibraryFileUpload::make('trailer')
                            ->collection('trailer')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['mp4', 'mov', 'avi', 'wmv', 'flv', 'mkv', 'webm'])
                            ->enableOpen(),
                    ])->collapsed(),

                Forms\Components\Section::make('Share Configuration')
                    ->description('This is the information which is used when the user shares the show with someone else.')
                    ->schema([
                        Forms\Components\TextInput::make('share_text')
                            ->nullable()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('share_url')
                            ->url()
                            ->nullable()
                            ->maxLength(2000),

                        Forms\Components\TextInput::make('external_group_url')
                            ->url()
                            ->nullable()
                            ->maxLength(2000),
                    ])->collapsed(),

                Forms\Components\Section::make('Google Analytics')
                    ->description('Id\'s for Google Analytics, Google Tag Manager and Google Universal Analytics.')
                    ->schema([
                        Forms\Components\TextInput::make('gua_id')
                            ->label('Google Universal Analytics Id')
                            ->startsWith('UA-')
                            ->nullable()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('ga4_id')
                            ->label('Google Analytics 4 Id')
                            ->startsWith('G-')
                            ->nullable()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('gtm_id')
                            ->label('Google Tag Manager Id')
                            ->startsWith('GTM-')
                            ->nullable()
                            ->maxLength(255),
                    ])->collapsed(),

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('icon')
                    ->collection('icon')
                    ->conversion('120'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('genre.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->money('eur'),

                Tables\Columns\TextColumn::make('transaction_costs')
                    ->money('eur'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            FeedItemsRelationManager::class,
            ConversationRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShows::route('/'),
            'create' => Pages\CreateShow::route('/create'),
            'edit' => Pages\EditShow::route('/{record}/edit'),
            'view' => Pages\ViewShow::route('/{record}'),
        ];
    }
}
