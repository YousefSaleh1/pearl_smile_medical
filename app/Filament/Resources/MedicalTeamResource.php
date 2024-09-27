<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalTeamResource\Pages;
use App\Filament\Resources\MedicalTeamResource\RelationManagers;
use App\Models\MedicalTeam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class MedicalTeamResource extends Resource
{
    protected static ?string $model = MedicalTeam::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_en')
                    ->required()
                    ->autocapitalize('words')
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_ar')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('specializations_en')
                    ->required()
                    ->autocapitalize('words')
                    ->maxLength(255),
                Forms\Components\TextInput::make('specializations_ar')
                    ->required()
                    ->maxLength(255),
                Forms\Components\MarkdownEditor::make('resume_en')
                    ->required()
                    ->disableToolbarButtons([
                        'attachFiles',
                        'teable',
                    ])
                    ->maxLength(65535),
                Forms\Components\MarkdownEditor::make('resume_ar')
                    ->required()
                    ->disableToolbarButtons([
                        'attachFiles',
                        'teable',
                    ])
                    ->maxLength(65535),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\MultiSelect::make('services')
                    ->label('Services')
                    ->relationship('services', 'title_en')
                    ->nullable(),
                Forms\Components\Repeater::make('images')
                    ->label('Image')
                    ->relationship('images')
                    ->maxItems(1)
                    ->schema([
                        Forms\Components\FileUpload::make('path')
                            ->label('Upload Image')
                            ->preserveFilenames()
                            ->directory('image/MedicalTeams')
                            ->imageEditor()
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend(now()->timestamp),
                            )
                            ->openable()
                            ->downloadable()
                            ->required(),

                        Forms\Components\Grid::make(2) // Create a grid layout for alt text
                            ->schema([
                                Forms\Components\TextInput::make('alt_en')
                                    ->label('Alt Text (English)')
                                    ->required(),

                                Forms\Components\TextInput::make('alt_ar')
                                    ->label('Alt Text (Arabic)')
                                    ->required(),
                            ]),
                    ]),
                Forms\Components\Repeater::make('videos')
                    ->label('Video')
                    ->relationship('videos')
                    ->maxItems(1)
                    ->schema([
                        Forms\Components\FileUpload::make('path')
                            ->label('Upload Video')
                            ->preserveFilenames()
                            ->directory('video/MedicalTeams')
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
                                    ->required(),

                                Forms\Components\TextInput::make('description_ar')
                                    ->label('Description (Arabic)')
                                    ->required(),
                            ]),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (English)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('specializations_en')
                    ->label('Specializations (English)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resume_en')
                    ->label('Resume (English)')
                    ->words(6)
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Phone Number')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->searchable()
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->searchable()
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('service_id')
                ->label('Service')
                ->relationship('services', 'title_en')
                ->searchable()
                ->preload()
                ->multiple(),
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
            'index' => Pages\ListMedicalTeams::route('/'),
            'create' => Pages\CreateMedicalTeam::route('/create'),
            'view' => Pages\ViewMedicalTeam::route('/{record}'),
            'edit' => Pages\EditMedicalTeam::route('/{record}/edit'),
        ];
    }
}
