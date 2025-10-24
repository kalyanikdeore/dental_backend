<?php

namespace App\Filament\Resources\AboutStoryResource\Pages;

use App\Filament\Resources\AboutStoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutStories extends ListRecords
{
    protected static string $resource = AboutStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
