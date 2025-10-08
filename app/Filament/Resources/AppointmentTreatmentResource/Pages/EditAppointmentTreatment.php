<?php

namespace App\Filament\Resources\AppointmentTreatmentResource\Pages;

use App\Filament\Resources\AppointmentTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppointmentTreatment extends EditRecord
{
    protected static string $resource = AppointmentTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
