<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Blog;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BlogResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BlogResource\RelationManagers;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content & Media';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (English)')
                            ->placeholder('Enter the blog title in English')
                            ->required()
                            ->maxLength(255)
                            ->helperText('This title will appear in the English version of the blog'),

                        Forms\Components\TextInput::make('title_ar')
                            ->label('Title (Arabic)')
                            ->placeholder('Enter the blog title in Arabic')
                            ->required()
                            ->maxLength(255)
                            ->helperText('This title will appear in the Arabic version of the blog'),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\MarkdownEditor::make('description_en')
                            ->label('Description (English)')
                            ->placeholder('Enter the blog description in English')
                            ->required()
                            ->maxLength(65535)
                            ->helperText('Detailed description in English'),

                        Forms\Components\MarkdownEditor::make('description_ar')
                            ->label('Description (Arabic)')
                            ->placeholder('Enter the blog description in Arabic')
                            ->required()
                            ->maxLength(65535)
                            ->helperText('Detailed description in Arabic'),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('tags_en')
                            ->label('Tags (English)')
                            ->placeholder('e.g., cosmetic surgery, Botox, fillers')
                            ->required()
                            ->helperText('For example: cosmetic surgery, laser treatment, skin rejuvenation'),

                        Forms\Components\TextInput::make('tags_ar')
                            ->label('Tags (Arabic)')
                            ->placeholder('مثال: جراحة تجميلية، بوتوكس، مواد مالئة')
                            ->required()
                            ->helperText('على سبيل المثال: جراحة تجميلية، علاج بالليزر، تجديد البشرة'),
                    ]),

                Forms\Components\Repeater::make('images')
                    ->label('Images')
                    ->relationship('images')
                    ->maxItems(1)
                    ->columnSpan('full')
                    ->schema([
                        Forms\Components\FileUpload::make('path')
                            ->label('Upload Image')
                            ->preserveFilenames()
                            ->directory('image/Blogs')
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
                                    ->placeholder('Enter alternative text for the image in English')
                                    ->required(),

                                Forms\Components\TextInput::make('alt_ar')
                                    ->label('Alt Text (Arabic)')
                                    ->placeholder('Enter alternative text for the image in Arabic')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description_en')
                    ->label('Description')
                    ->searchable()
                    ->words(6),
                Tables\Columns\TextColumn::make('tags_en')
                    ->label('Tags')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('images.path')
                    ->label('Image')
                    ->size(50) // Adjust the size of the image thumbnail
                    ->getStateUsing(fn ($record) => $record->images->first()?->path) // Get the first image's path
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'view' => Pages\ViewBlog::route('/{record}'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
