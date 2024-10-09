<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Filament\Resources\AboutResource\RelationManagers;
use App\Models\About;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $navigationIcon = 'heroicon-s-information-circle';

    protected static ?string $navigationGroup = 'Clinic Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->required()
                            ->maxLength(65535),
                        Forms\Components\Textarea::make('description_ar')
                            ->label('Description (Arabic)')
                            ->required()
                            ->maxLength(65535),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('address_en')
                            ->label('Address (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address_ar')
                            ->label('Address (Arabic)')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('mobile_numbers')
                            ->label('Mobile Numbers')
                            ->required()
                            ->helperText('For example: +971809820938,+97180943434,+97180943434'),
                        Forms\Components\TextInput::make('facebook_link')
                            ->label('Facebook Link')
                            ->url()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('instegram_link')
                            ->label('Instagram Link')
                            ->url()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tiktok_link')
                            ->label('TikTok Link')
                            ->url()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->url()
                            ->required()
                            ->maxLength(255)
                            ->helperText('You should add the whatsapp link not number'),
                    ]),

                Forms\Components\Section::make('Videos')
                    ->schema([
                        Forms\Components\Repeater::make('videos')
                            ->label('Video')
                            ->relationship('videos')
                            ->schema([
                                Forms\Components\TextInput::make('path')
                                ->label('Video Link')
                                ->url()
                                ->required()
                                ->maxLength(255)
                                ->helperText('Please enter the video link')
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $embedLink = str_replace('youtu.be/', 'www.youtube.com/embed/', $state);

                                    if (strpos($embedLink, 'youtube.com/shorts/') !== false) {
                                        $embedLink = str_replace('youtube.com/shorts/', 'www.youtube.com/embed/', $embedLink);
                                    }

                                    $embedLink = strtok($embedLink, '?');

                                    $set('path', $embedLink);
                                }),

                            Forms\Components\ViewField::make('path')
                                ->label('Video Preview')
                                ->view('components.video-preview'),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('description_en')
                                            ->label('Description (English)'),
                                        Forms\Components\TextInput::make('description_ar')
                                            ->label('Description (Arabic)'),
                                    ]),
                            ]),
                    ]),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('Whatsapp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facebook_link')
                    ->label('facebook link')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('instegram_link')
                    ->label('Instagram link')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tiktok_link')
                    ->label('TikTok link')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Phone Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile_numbers')
                    ->label('Mobile Numbers')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address_en')
                    ->label('Address')
                    ->words(5)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->searchable()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->searchable()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAbouts::route('/'),
            'view' => Pages\ViewAbout::route('/{record}'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}
