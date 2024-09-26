<?php

namespace App\Filament\Resources\WorkingTimeResource\Pages;

use App\Filament\Resources\WorkingTimeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkingTime extends ViewRecord
{
    protected static string $resource = WorkingTimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
