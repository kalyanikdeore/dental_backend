<?php

namespace App\Filament\Resources\PageSettingResource\Pages;

use App\Filament\Resources\PageSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPageSetting extends EditRecord
{
    protected static string $resource = PageSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
