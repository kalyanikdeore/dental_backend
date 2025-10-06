<?php

namespace App\Filament\Resources\PatientSafetySectionResource\Pages;

use App\Filament\Resources\PatientSafetySectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatientSafetySection extends EditRecord
{
    protected static string $resource = PatientSafetySectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
