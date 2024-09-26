<?php

namespace App\Filament\Resources\GalaryResource\Pages;

use App\Filament\Resources\GalaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGalary extends ViewRecord
{
    protected static string $resource = GalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
