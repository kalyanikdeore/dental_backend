<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookAppointmentSubmissionResource\Pages;
use App\Models\BookAppointmentSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookAppointmentSubmissionResource extends Resource
{
    protected static ?string $model = BookAppointmentSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Contactus page ';
    protected static ?string $pluralModelLabel = 'Book Appointmentss';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Appointment Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('preferred_service')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('preferred_date')
                            ->required()
                            ->date(),
                        Forms\Components\TextInput::make('preferred_clinic')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Additional Message')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('preferred_service')
                    ->searchable()
                    ->sortable()
                    ->label('Service'),
                Tables\Columns\TextColumn::make('preferred_date')
                    ->date()
                    ->sortable()
                    ->label('Preferred Date'),
                Tables\Columns\TextColumn::make('preferred_clinic')
                    ->searchable()
                    ->sortable()
                    ->label('Clinic'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Submitted At'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('preferred_clinic')
                    ->options(function () {
                        return \App\Models\ContactInformation::pluck('name', 'name')->toArray();
                    })
                    ->label('Filter by Clinic'),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(), // Only delete action remains
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookAppointmentSubmissions::route('/'),
            // Removed both edit and view pages
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    // Add this method to prevent editing
    public static function canEdit($record): bool
    {
        return false;
    }
}