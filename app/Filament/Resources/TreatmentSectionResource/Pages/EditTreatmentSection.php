<?php

namespace App\Filament\Resources\TreatmentSectionResource\Pages;

use App\Filament\Resources\TreatmentSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTreatmentSection extends EditRecord
{
    protected static string $resource = TreatmentSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
