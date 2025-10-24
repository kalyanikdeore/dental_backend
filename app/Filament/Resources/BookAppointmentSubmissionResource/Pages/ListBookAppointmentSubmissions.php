<?php

namespace App\Filament\Resources\BookAppointmentSubmissionResource\Pages;

use App\Filament\Resources\BookAppointmentSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookAppointmentSubmissions extends ListRecords
{
    protected static string $resource = BookAppointmentSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
