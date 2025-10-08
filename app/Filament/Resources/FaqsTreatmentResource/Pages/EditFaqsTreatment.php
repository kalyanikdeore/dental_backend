<?php

namespace App\Filament\Resources\FaqsTreatmentResource\Pages;

use App\Filament\Resources\FaqsTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFaqsTreatment extends EditRecord
{
    protected static string $resource = FaqsTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
