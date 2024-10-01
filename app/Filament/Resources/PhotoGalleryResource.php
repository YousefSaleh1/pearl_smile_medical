<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotoGalleryResource\Pages;
use App\Filament\Resources\PhotoGalleryResource\RelationManagers;
use App\Models\PhotoGallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PhotoGalleryResource extends Resource
{
    protected static ?string $model = PhotoGallery::class;

    protected static ?string $navigationLabel = 'Photo Gallery';

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $navigationGroup = 'Content & Media';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Repeater::make('images')
                    ->label('Images')
                    ->relationship('images')
                    ->maxItems(1)
                    ->columnSpan('full')
                    ->schema([
                        Forms\Components\FileUpload::make('path')
                            ->label('Upload Image')
                            ->preserveFilenames()
                            ->directory('image/Galary')
                            ->imageEditor()
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend(now()->timestamp),
                            )
                            ->openable()
                            ->downloadable()
                            ->required(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('alt_en')
                                    ->label('Alt Text (English)')
                                    ->placeholder('Enter alt text in English')
                                    ->required(),

                                Forms\Components\TextInput::make('alt_ar')
                                    ->label('Alt Text (Arabic)')
                                    ->placeholder('Enter alt text in Arabic')
                                    ->required(),
                            ]),
                    ])
                    ->columns(1)
                    ->defaultItems(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images.path')
                    ->label('Images')
                    ->size(100)
                    ->limitedRemainingText()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->searchable()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
            'index' => Pages\ListPhotoGalaries::route('/'),
            'create' => Pages\CreatePhotoGalary::route('/create'),
            'edit' => Pages\EditPhotoGalary::route('/{record}/edit'),
        ];
    }
}
