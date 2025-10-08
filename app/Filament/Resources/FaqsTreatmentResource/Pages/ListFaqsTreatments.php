<?php

namespace App\Filament\Resources\FaqsTreatmentResource\Pages;

use App\Filament\Resources\FaqsTreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFaqsTreatments extends ListRecords
{
    protected static string $resource = FaqsTreatmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
