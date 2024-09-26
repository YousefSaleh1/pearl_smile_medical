<?php

namespace App\Filament\Resources\GalaryResource\Pages;

use App\Filament\Resources\GalaryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGalary extends EditRecord
{
    protected static string $resource = GalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
