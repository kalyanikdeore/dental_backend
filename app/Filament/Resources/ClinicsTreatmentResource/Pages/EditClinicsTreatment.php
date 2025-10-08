<?php

namespace App\Filament\Resources\ClinicsTreatmentResource\Pages;

use App\Filament\Resources\ClinicsTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClinicsTreatment extends EditRecord
{
    protected static string $resource = ClinicsTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
