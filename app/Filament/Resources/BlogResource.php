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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title_en')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title_ar')
                    ->required()
                    ->maxLength(255),
                Forms\Components\MarkdownEditor::make('description_en')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\MarkdownEditor::make('description_ar')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\TextInput::make('tags_en')
                    ->required(),
                Forms\Components\TextInput::make('tags_ar')
                    ->required(),
                Forms\Components\Repeater::make('images')
                ->label('Image')
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

                    Forms\Components\Grid::make(2) // Create a grid layout for alt text
                        ->schema([
                            Forms\Components\TextInput::make('alt_en')
                                ->label('Alt Text (English)')
                                ->required(),

                            Forms\Components\TextInput::make('alt_ar')
                                ->label('Alt Text (Arabic)')
                                ->required(),
                        ]),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description_en')
                    ->searchable()
                    ->words(6),
                Tables\Columns\TextColumn::make('tags_en')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('images.path')
                    ->label('Image')
                    ->size(50) // Adjust the size of the image thumbnail
                    ->getStateUsing(fn ($record) => $record->images->first()?->path) // Get the first image's path

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
                //
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'view' => Pages\ViewBlog::route('/{record}'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
