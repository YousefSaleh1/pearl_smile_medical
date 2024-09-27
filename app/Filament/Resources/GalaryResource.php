<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Galary;
use App\Enums\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GalaryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GalaryResource\RelationManagers;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class GalaryResource extends Resource
{
    protected static ?string $model = Galary::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationGroup = 'Content & Media';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category')
                    ->options(Category::class)
                    ->columnSpan('full'),
                Forms\Components\Repeater::make('images')
                    ->label('Image')
                    ->relationship('images')
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
                            ->nullable(),

                        Forms\Components\Grid::make(2) // Create a grid layout for alt text
                            ->schema([
                                Forms\Components\TextInput::make('alt_en')
                                    ->label('Alt Text (English)'),

                                Forms\Components\TextInput::make('alt_ar')
                                    ->label('Alt Text (Arabic)'),
                            ]),
                    ]),
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
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('images.path')
                    ->label('Images')
                    ->circular()
                    ->stacked()
                    ->ring(1)
                    ->limit(3)
                    ->limitedRemainingText()
                    ->toggleable(),

                    ViewColumn::make('videos.path')
                    ->label('Videos')
                    ->view('components.video-column')
                    ->toggleable(),

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
                SelectFilter::make('category')
                ->options(Category::class)
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListGalaries::route('/'),
            'create' => Pages\CreateGalary::route('/create'),
            'view' => Pages\ViewGalary::route('/{record}'),
            'edit' => Pages\EditGalary::route('/{record}/edit'),
        ];
    }
}
