<?php

namespace App\Filament\Resources\BookAppointmentSubmissionResource\Pages;

use App\Filament\Resources\BookAppointmentSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBookAppointmentSubmission extends ViewRecord
{
    protected static string $resource = BookAppointmentSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('back')
                ->label('Back to List')
                ->url(static::$resource::getUrl('index'))
                ->color('gray'),
        ];
    }
}