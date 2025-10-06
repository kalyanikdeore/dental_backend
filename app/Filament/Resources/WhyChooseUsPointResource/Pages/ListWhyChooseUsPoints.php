<?php

namespace App\Filament\Resources\WhyChooseUsPointResource\Pages;

use App\Filament\Resources\WhyChooseUsPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWhyChooseUsPoints extends ListRecords
{
    protected static string $resource = WhyChooseUsPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
