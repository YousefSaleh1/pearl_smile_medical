<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Tables\Filters\SelectFilter;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-c-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Tabs::make('Service Details')
                            ->tabs([

                                // Tab for Service with English and Arabic fields
                                Forms\Components\Tabs\Tab::make('Service')
                                    ->schema([
                                        Forms\Components\Grid::make(2) // Create a grid layout
                                            ->schema([
                                                Forms\Components\TextInput::make('title_en')
                                                    ->label('Title (English)')
                                                    ->autocapitalize('words')
                                                    ->minLength(2)
                                                    ->maxLength(255)
                                                    ->required(),

                                                Forms\Components\TextInput::make('title_ar')
                                                    ->label('Title (Arabic)')
                                                    ->minLength(2)
                                                    ->maxLength(255)
                                                    ->required(),

                                                Forms\Components\MarkdownEditor::make('description_en')
                                                    ->label('Description (English)')
                                                    ->disableToolbarButtons([
                                                        'attachFiles',
                                                        'teable',
                                                    ])
                                                    ->required(),

                                                Forms\Components\MarkdownEditor::make('description_ar')
                                                    ->label('Description (Arabic)')
                                                    ->disableToolbarButtons([
                                                        'attachFiles',
                                                        'teable',
                                                    ])
                                                    ->required(),
                                                Forms\Components\MultiSelect::make('medical_teams')
                                                    ->label('Medical Teams')
                                                    ->relationship('medical_teams', 'name_en')
                                                    ->columnSpanFull()
                                                    ->nullable(),

                                            ]),
                                    ]),

                                // Tab for Sections with English and Arabic fields
                                Forms\Components\Tabs\Tab::make('Sections')
                                    ->schema([
                                        Forms\Components\Repeater::make('sections')
                                            ->label('Sections')
                                            ->relationship('sections')
                                            ->schema([
                                                Forms\Components\Grid::make(2) // Create a grid layout for sections
                                                    ->schema([
                                                        Forms\Components\TextInput::make('section_name_en')
                                                            ->label('Section Name (English)')
                                                            ->autocapitalize('words')
                                                            ->minLength(2)
                                                            ->maxLength(255)
                                                            ->required(),

                                                        Forms\Components\TextInput::make('section_name_ar')
                                                            ->label('Section Name (Arabic)')
                                                            ->minLength(2)
                                                            ->maxLength(255)
                                                            ->required(),

                                                        Forms\Components\MarkdownEditor::make('description_en')
                                                            ->label('Description (English)')
                                                            ->disableToolbarButtons([
                                                                'attachFiles',
                                                                'teable',
                                                            ])
                                                            ->required(),

                                                        Forms\Components\MarkdownEditor::make('description_ar')
                                                            ->label('Description (Arabic)')
                                                            ->disableToolbarButtons([
                                                                'attachFiles',
                                                                'teable',
                                                            ])
                                                            ->required(),

                                                    ]),

                                                // Image upload for section with alt text in both languages
                                                Forms\Components\Repeater::make('images')
                                                    ->label('Image')
                                                    ->relationship('images')
                                                    ->maxItems(1)
                                                    ->schema([
                                                        Forms\Components\FileUpload::make('path')
                                                            ->label('Upload Image')
                                                            ->preserveFilenames()
                                                            ->directory('image/Sections')
                                                            ->imageEditor()
                                                            ->getUploadedFileNameForStorageUsing(
                                                                fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                                                    ->prepend(now()->timestamp),
                                                            )
                                                            ->openable()
                                                            ->downloadable()
                                                            ->required(),

                                                        Forms\Components\Grid::make(2) // Create a grid layout for alt text
                                                            ->schema([
                                                                Forms\Components\TextInput::make('alt_en')
                                                                    ->label('Alt Text (English)')
                                                                    ->minLength(2)
                                                                    ->maxLength(50)
                                                                    ->required(),

                                                                Forms\Components\TextInput::make('alt_ar')
                                                                    ->label('Alt Text (Arabic)')
                                                                    ->minLength(2)
                                                                    ->maxLength(50)
                                                                    ->required(),
                                                            ]),
                                                    ])
                                                    ->createItemButtonLabel('Add Image'),

                                                Forms\Components\Repeater::make('videos')
                                                    ->label('Video')
                                                    ->relationship('videos')
                                                    ->maxItems(1)
                                                    ->schema([
                                                        Forms\Components\FileUpload::make('path')
                                                            ->label('Upload Video')
                                                            ->preserveFilenames()
                                                            ->directory('video/Sections')
                                                            ->getUploadedFileNameForStorageUsing(
                                                                fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                                                    ->prepend(now()->timestamp),
                                                            )
                                                            ->openable()
                                                            ->downloadable()
                                                            ->required(),

                                                        Forms\Components\Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('description_en')
                                                                    ->label('Description (English)')
                                                                    ->minLength(2)
                                                                    ->maxLength(100)
                                                                    ->required(),

                                                                Forms\Components\TextInput::make('description_ar')
                                                                    ->label('Description (Arabic)')
                                                                    ->minLength(2)
                                                                    ->maxLength(100)
                                                                    ->required(),
                                                            ]),
                                                    ]),
                                            ])
                                            ->createItemButtonLabel('Add Section'),
                                    ]),

                                // Tab for FAQs with English and Arabic fields
                                Forms\Components\Tabs\Tab::make('FAQs')
                                    ->schema([
                                        Forms\Components\Repeater::make('faqs')
                                            ->label('FAQs')
                                            ->relationship('faqs')
                                            ->schema([
                                                Forms\Components\Grid::make(2) // Create a grid layout for FAQs
                                                    ->schema([
                                                        Forms\Components\TextInput::make('question_en')
                                                            ->label('Question (English)')
                                                            // ->autocapitalize('words')
                                                            ->required(),

                                                        Forms\Components\TextInput::make('question_ar')
                                                            ->label('Question (Arabic)')
                                                            ->required(),

                                                        Forms\Components\MarkdownEditor::make('answer_en')
                                                            ->label('Answer (English)')
                                                            ->disableToolbarButtons([
                                                                'attachFiles',
                                                                'teable',
                                                            ])
                                                            ->required(),

                                                        Forms\Components\MarkdownEditor::make('answer_ar')
                                                            ->label('Answer (Arabic)')
                                                            ->disableToolbarButtons([
                                                                'attachFiles',
                                                                'teable',
                                                            ])
                                                            ->required(),
                                                    ]),
                                            ])
                                            ->createItemButtonLabel('Add FAQ'),
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
                Tables\Columns\TextColumn::make('title_en')
                    ->searchable()
                    ->label('Title (English)'),
                Tables\Columns\TextColumn::make('description_en')
                    ->searchable()
                    ->label('Description (English)'),
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
                SelectFilter::make('medical_team_id')
                ->label('Medical Team')
                ->relationship('medical_teams', 'name_en')
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'view' => Pages\ViewService::route('/{record}'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
