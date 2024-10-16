<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkingTimeResource\Pages;
use App\Filament\Resources\WorkingTimeResource\RelationManagers;
use App\Models\WorkingTime;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkingTimeResource extends Resource
{
    protected static ?string $model = WorkingTime::class;

    protected static ?string $navigationIcon = 'heroicon-s-clock';

    protected static ?string $navigationGroup = 'Clinic Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('days')
                    ->label('Working Days')
                    ->placeholder('Enter the working days (e.g., Monday to Friday)')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Example: Monday to Friday'),

                Forms\Components\TimePicker::make('of_time')
                    ->label('Start Time')
                    ->placeholder('Select the starting time')
                    ->required()
                    ->minutesStep(15)
                    ->helperText('Choose the start time of the working hours'),

                Forms\Components\TimePicker::make('until_time')
                    ->label('End Time')
                    ->placeholder('Select the ending time')
                    ->required()
                    ->minutesStep(15)
                    ->helperText('Choose the end time of the working hours'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('days')
                    ->label('Days'),
                Tables\Columns\TextColumn::make('of_time')
                    ->label('Of Time'),
                Tables\Columns\TextColumn::make('until_time')
                    ->label('Until Time'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
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
            'index' => Pages\ListWorkingTimes::route('/'),
            // 'create' => Pages\CreateWorkingTime::route('/create'),
            'view' => Pages\ViewWorkingTime::route('/{record}'),
            'edit' => Pages\EditWorkingTime::route('/{record}/edit'),
        ];
    }
}
