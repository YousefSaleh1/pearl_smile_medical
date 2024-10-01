<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoGalleryResource\Pages;
use App\Filament\Resources\VideoGalleryResource\RelationManagers;
use App\Models\VideoGallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class VideoGalleryResource extends Resource
{
    protected static ?string $model = VideoGallery::class;

    protected static ?string $navigationLabel = 'Video Gallery';

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'Content & Media';

    // protected static ?string $navigationParentItem = 'Galary';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Repeater::make('videos')
                    ->label('Videos')
                    ->relationship('videos')
                    ->maxItems(1)
                    ->schema([
                        Forms\Components\FileUpload::make('path')
                            ->label('Upload Video')
                            ->preserveFilenames()
                            ->directory('video/Galary')
                            ->maxSize(409600)
                            ->acceptedFileTypes(['video/mp4', 'video/ogg', 'video/webm'])
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend(now()->timestamp),
                            )
                            ->openable()
                            ->downloadable()
                            ->required(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('description_en')
                                    ->label('Description (English)')
                                    ->placeholder('Enter video description in English'),

                                Forms\Components\TextInput::make('description_ar')
                                    ->label('Description (Arabic)')
                                    ->placeholder('Enter video description in Arabic'),
                            ]),
                    ])
                    ->columns(1)
                    ->defaultItems(1)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('videos')
                    ->label('Videos')
                    ->view('components.video-column'),
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
            'index' => Pages\ListVideoGalaries::route('/'),
            'create' => Pages\CreateVideoGalary::route('/create'),
            'edit' => Pages\EditVideoGalary::route('/{record}/edit'),
        ];
    }
}
