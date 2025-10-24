<?php

namespace App\Filament\Resources\TreatmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AppointmentTreatmentRelationManager extends RelationManager
{
    protected static string $relationship = 'appointmentTreatments';

    protected static ?string $title = 'Appointments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Patient Name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('deolali_phone')
                    ->label('Deolali Phone')
                    ->tel()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('nashik_phone')
                    ->label('Nashik Phone')
                    ->tel()
                    ->maxLength(255),
                
                Forms\Components\DatePicker::make('preferred_date')
                    ->label('Preferred Date')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                
                Forms\Components\TimePicker::make('preferred_time')
                    ->label('Preferred Time')
                    ->required()
                    ->seconds(false)
                    ->native(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Patient Name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('deolali_phone')
                    ->label('Deolali Phone')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('nashik_phone')
                    ->label('Nashik Phone')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('preferred_date')
                    ->label('Preferred Date')
                    ->date('d/m/Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('preferred_time')
                    ->label('Preferred Time')
                    ->time('h:i A')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('preferred_date', 'desc');
    }
}