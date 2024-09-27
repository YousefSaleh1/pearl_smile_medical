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
                Forms\Components\Textarea::make('description_en')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description_ar')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('facebook_link')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('instegram_link')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('whatsapp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_numbers')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address_en')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address_ar')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Repeater::make('videos')
                    ->label('Video')
                    ->relationship('videos')
                    ->schema([
                        Forms\Components\FileUpload::make('path')
                            ->label('Upload Video')
                            ->preserveFilenames()
                            ->directory('video/Galary')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend(now()->timestamp),
                            )
                            ->openable()
                            ->downloadable()
                            ->nullable(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('description_en')
                                    ->label('Description (English)'),

                                Forms\Components\TextInput::make('description_ar')
                                    ->label('Description (Arabic)'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facebook_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instegram_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_numbers')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_ar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
