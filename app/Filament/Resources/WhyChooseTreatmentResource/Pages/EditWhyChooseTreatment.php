<?php

namespace App\Filament\Resources\WhyChooseTreatmentResource\Pages;

use App\Filament\Resources\WhyChooseTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhyChooseTreatment extends EditRecord
{
    protected static string $resource = WhyChooseTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
