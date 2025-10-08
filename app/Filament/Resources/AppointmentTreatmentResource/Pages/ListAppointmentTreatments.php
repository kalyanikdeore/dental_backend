<?php

namespace App\Filament\Resources\AppointmentTreatmentResource\Pages;

use App\Filament\Resources\AppointmentTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppointmentTreatments extends ListRecords
{
    protected static string $resource = AppointmentTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
