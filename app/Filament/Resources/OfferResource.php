<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Filament\Resources\OfferResource\RelationManagers;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-c-gift';

    protected static ?string $navigationGroup = 'Services and Offers';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('service_id')
                            ->relationship('service', 'title_en')
                            ->required()
                            ->label('Select Service')
                            ->placeholder('Choose a service...'),

                        Forms\Components\Repeater::make('images')
                            ->label('Upload Images')
                            ->relationship('images')
                            ->maxItems(2)
                            ->schema([
                                Forms\Components\FileUpload::make('path')
                                    ->label('Upload Image')
                                    ->preserveFilenames()
                                    ->directory('image/Offers')
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
                                            ->minLength(2)
                                            ->maxLength(100)
                                            ->required()
                                            ->placeholder('Enter alt text for the image in English'),

                                        Forms\Components\TextInput::make('alt_ar')
                                            ->label('Alt Text (Arabic)')
                                            ->minLength(2)
                                            ->maxLength(100)
                                            ->required()
                                            ->placeholder('Enter alt text for the image in Arabic'),
                                    ]),
                            ])
                            ->createItemButtonLabel('Add Another Image'),
                    ])
                    ->columnSpanFull()
                    ->description('Please fill in all the required fields and upload images related to the offer.'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service.title_en')
                    ->label('Service')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('images.path')
                    ->label('Images')
                    ->circular()
                    ->stacked()
                    ->size(50)
                    ->ring(1)
                    ->limit(3)
                    ->limitedRemainingText()
                    ->toggleable(),
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
                SelectFilter::make('service_id')
                    ->label('Service')
                    ->relationship('service', 'title_en')
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->deferFilters()
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'view' => Pages\ViewOffer::route('/{record}'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
