<?php

namespace App\Filament\Resources\WelcomeSectionResource\Pages;

use App\Filament\Resources\WelcomeSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWelcomeSection extends EditRecord
{
    protected static string $resource = WelcomeSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
