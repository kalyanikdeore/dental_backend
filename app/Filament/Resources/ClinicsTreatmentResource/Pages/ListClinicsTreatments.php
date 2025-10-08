<?php

namespace App\Filament\Resources\ClinicsTreatmentResource\Pages;

use App\Filament\Resources\ClinicsTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClinicsTreatments extends ListRecords
{
    protected static string $resource = ClinicsTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
