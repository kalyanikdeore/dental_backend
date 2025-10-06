<?php

namespace App\Filament\Resources\DoctorFaqResource\Pages;

use App\Filament\Resources\DoctorFaqResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDoctorFaqs extends ListRecords
{
    protected static string $resource = DoctorFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
