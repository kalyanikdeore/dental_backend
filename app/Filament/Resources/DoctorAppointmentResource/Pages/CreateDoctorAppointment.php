<?php

namespace App\Filament\Resources\DoctorAppointmentResource\Pages;

use App\Filament\Resources\DoctorAppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctorAppointment extends CreateRecord
{
    protected static string $resource = DoctorAppointmentResource::class;
}
