<?php

namespace App\Filament\Resources\MedicalTeamResource\Pages;

use App\Filament\Resources\MedicalTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMedicalTeam extends ViewRecord
{
    protected static string $resource = MedicalTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
