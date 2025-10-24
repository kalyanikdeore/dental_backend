<?php

namespace App\Filament\Resources\DoctorAppointmentResource\Pages;

use App\Filament\Resources\DoctorAppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDoctorAppointments extends ListRecords
{
    protected static string $resource = DoctorAppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
