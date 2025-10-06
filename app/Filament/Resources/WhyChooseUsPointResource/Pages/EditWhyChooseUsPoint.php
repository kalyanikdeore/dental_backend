<?php

namespace App\Filament\Resources\WhyChooseUsPointResource\Pages;

use App\Filament\Resources\WhyChooseUsPointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhyChooseUsPoint extends EditRecord
{
    protected static string $resource = WhyChooseUsPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
