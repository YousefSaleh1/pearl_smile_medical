<?php

namespace App\Filament\Resources\GalaryResource\Pages;
use Filament\Tables\Table;
use App\Filament\Resources\GalaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGalaries extends ListRecords
{
    protected static string $resource = GalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
