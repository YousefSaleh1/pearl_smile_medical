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

    protected static ?string $navigationIcon = 'heroicon-m-user-group';

    protected static ?string $navigationGroup = 'Medical Team';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([

                        // Section for Personal Information
                        Forms\Components\Section::make('Personal Information')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('name_en')
                                            ->label('Name (English)')
                                            ->required()
                                            ->autocapitalize('words')
                                            ->maxLength(255)
                                            ->placeholder('Enter name in English'),

                                        Forms\Components\TextInput::make('name_ar')
                                            ->label('Name (Arabic)')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter name in Arabic'),
                                    ]),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('phone_number')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter phone number'),

                                        Forms\Components\TextInput::make('email')
                                            ->label('Email Address')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('example@domain.com'),
                                    ]),
                            ]),

                        // Section for Professional Details
                        Forms\Components\Section::make('Professional Details')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('specializations_en')
                                            ->label('Specializations (English)')
                                            ->required()
                                            ->autocapitalize('words')
                                            ->maxLength(255)
                                            ->placeholder('Enter specializations in English'),

                                        Forms\Components\TextInput::make('specializations_ar')
                                            ->label('Specializations (Arabic)')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter specializations in Arabic'),
                                    ]),

                                Forms\Components\MarkdownEditor::make('resume_en')
                                    ->label('Resume (English)')
                                    ->required()
                                    ->disableToolbarButtons(['attachFiles', 'teable'])
                                    ->maxLength(65535)
                                    ->placeholder('Enter resume details in English'),

                                Forms\Components\MarkdownEditor::make('resume_ar')
                                    ->label('Resume (Arabic)')
                                    ->required()
                                    ->disableToolbarButtons(['attachFiles', 'teable'])
                                    ->maxLength(65535)
                                    ->placeholder('Enter resume details in Arabic'),
                            ]),

                        // Section for Services and Media
                        Forms\Components\Section::make('Services and Media')
                            ->schema([
                                Forms\Components\MultiSelect::make('services')
                                    ->label('Services Provided')
                                    ->relationship('services', 'title_en')
                                    ->nullable(),

                                Forms\Components\Repeater::make('images')
                                    ->label('Images')
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
                                            ->required()
                                            ->helperText('Upload a clear image of the medical team member.'),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('alt_en')
                                                    ->label('Alt Text (English)')
                                                    ->required()
                                                    ->placeholder('Enter alt text for the image in English'),

                                                Forms\Components\TextInput::make('alt_ar')
                                                    ->label('Alt Text (Arabic)')
                                                    ->required()
                                                    ->placeholder('Enter alt text for the image in Arabic'),
                                            ]),
                                    ]),

                                Forms\Components\Repeater::make('videos')
                                    ->label('Videos')
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
                                            ->required()
                                            ->helperText('Upload a clear video introduction of the team member.'),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('description_en')
                                                    ->label('Description (English)')
                                                    ->required()
                                                    ->placeholder('Enter video description in English'),

                                                Forms\Components\TextInput::make('description_ar')
                                                    ->label('Description (Arabic)')
                                                    ->required()
                                                    ->placeholder('Enter video description in Arabic'),
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(), // Full width for the card
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('specializations_en')
                    ->label('Specializations')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resume_en')
                    ->label('Resume')
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
            'index' => Pages\ListMedicalTeams::route('/'),
            'create' => Pages\CreateMedicalTeam::route('/create'),
            'view' => Pages\ViewMedicalTeam::route('/{record}'),
            'edit' => Pages\EditMedicalTeam::route('/{record}/edit'),
        ];
    }
}
