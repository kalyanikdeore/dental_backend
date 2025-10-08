<?php

namespace App\Filament\Resources\WhyChooseTreatmentResource\Pages;

use App\Filament\Resources\WhyChooseTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWhyChooseTreatments extends ListRecords
{
    protected static string $resource = WhyChooseTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
