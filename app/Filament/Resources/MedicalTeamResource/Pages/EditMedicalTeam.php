<?php

namespace App\Filament\Resources\MedicalTeamResource\Pages;

use App\Filament\Resources\MedicalTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedicalTeam extends EditRecord
{
    protected static string $resource = MedicalTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
