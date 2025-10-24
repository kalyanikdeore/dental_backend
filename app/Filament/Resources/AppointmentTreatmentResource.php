<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentTreatmentResource\Pages;
use App\Models\AppointmentTreatment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AppointmentTreatmentResource extends Resource
{
    protected static ?string $model = AppointmentTreatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
          protected static ?string $navigationGroup = 'Treatment page ';

    protected static ?string $navigationLabel = 'Book Appointments';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Appointment Information')
                    ->schema([
                        Forms\Components\Select::make('treatment_id')
                            ->label('Treatment')
                            ->relationship('treatment', 'h1') // Changed from 'name' to 'h1'
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->createOptionForm([
                                Forms\Components\TextInput::make('h1') // Changed from 'name' to 'h1'
                                    ->required()
                                    ->maxLength(255),
                            ]),

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
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('treatment.h1') // Changed from 'treatment.name' to 'treatment.h1'
                    ->label('Treatment')
                    ->sortable()
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('name')
                    ->label('Patient Name')
                    ->sortable()
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('deolali_phone')
                    ->label('Deolali Phone')
                    ->limit(20)
                    ->searchable(),

                Tables\Columns\TextColumn::make('nashik_phone')
                    ->label('Nashik Phone')
                    ->limit(20)
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

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('treatment')
                    ->relationship('treatment', 'h1') // Changed from 'name' to 'h1'
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('preferred_date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')->label('From Date'),
                        Forms\Components\DatePicker::make('date_until')->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('preferred_date', '>=', $date)
                            )
                            ->when(
                                $data['date_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('preferred_date', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointmentTreatments::route('/'),
            'create' => Pages\CreateAppointmentTreatment::route('/create'),
            'edit' => Pages\EditAppointmentTreatment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}