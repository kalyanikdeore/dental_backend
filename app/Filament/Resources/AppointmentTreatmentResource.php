<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentTreatmentResource\Pages;
use App\Models\AppointmentTreatment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class AppointmentTreatmentResource extends Resource
{
    protected static ?string $model = AppointmentTreatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Treatments';
    protected static ?string $navigationLabel = 'Appointments';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Appointment Details')
                    ->schema([
                        Forms\Components\Select::make('treatment_id')
                            ->relationship('treatment', 'h1')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending')
                            ->native(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Patient Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\Select::make('clinic_location')
                            ->options([
                                'deolali_camp' => 'Deolali Camp',
                                'nashik_road' => 'Nashik Road',
                            ])
                            ->required()
                            ->native(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Appointment Schedule')
                    ->schema([
                        Forms\Components\DatePicker::make('preferred_date')
                            ->required()
                            ->minDate(now()),
                        Forms\Components\TimePicker::make('preferred_time')
                            ->required()
                            ->seconds(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('treatment.h1')
                    ->sortable()
                    ->searchable()
                    ->limit(25),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('clinic_location')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'deolali_camp' => 'Deolali Camp',
                        'nashik_road' => 'Nashik Road',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'deolali_camp' => 'success',
                        'nashik_road' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('preferred_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('preferred_time')
                    ->time(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'completed' => 'info',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('treatment')
                    ->relationship('treatment', 'h1')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('clinic_location')
                    ->options([
                        'deolali_camp' => 'Deolali Camp',
                        'nashik_road' => 'Nashik Road',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Filter::make('upcoming_appointments')
                    ->query(fn (Builder $query): Builder => $query->where('preferred_date', '>=', now()->format('Y-m-d')))
                    ->label('Upcoming Appointments'),
                Filter::make('today_appointments')
                    ->query(fn (Builder $query): Builder => $query->whereDate('preferred_date', today()))
                    ->label("Today's Appointments"),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->action(function (AppointmentTreatment $record) {
                        $record->status = 'confirmed';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Confirm Appointment')
                    ->modalDescription('Are you sure you want to confirm this appointment?')
                    ->modalSubmitActionLabel('Yes, confirm')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn (AppointmentTreatment $record): bool => $record->status === 'pending'),
                Tables\Actions\Action::make('complete')
                    ->action(function (AppointmentTreatment $record) {
                        $record->status = 'completed';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('info')
                    ->icon('heroicon-o-check-badge')
                    ->visible(fn (AppointmentTreatment $record): bool => $record->status === 'confirmed'),
                Tables\Actions\Action::make('cancel')
                    ->action(function (AppointmentTreatment $record) {
                        $record->status = 'cancelled';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn (AppointmentTreatment $record): bool => in_array($record->status, ['pending', 'confirmed'])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('preferred_date', 'asc');
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
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('status', 'pending')->count() > 0 ? 'warning' : 'gray';
    }
}