<?php

namespace App\Filament\Resources\DoctorAppointmentResource\Pages;

use App\Filament\Resources\DoctorAppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDoctorAppointment extends EditRecord
{
    protected static string $resource = DoctorAppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
