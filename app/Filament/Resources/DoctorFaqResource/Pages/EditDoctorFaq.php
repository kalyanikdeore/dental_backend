<?php

namespace App\Filament\Resources\DoctorFaqResource\Pages;

use App\Filament\Resources\DoctorFaqResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDoctorFaq extends EditRecord
{
    protected static string $resource = DoctorFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
