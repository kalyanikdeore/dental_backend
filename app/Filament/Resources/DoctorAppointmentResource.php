<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorAppointmentResource\Pages;
use App\Models\DoctorAppointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DoctorAppointmentResource extends Resource
{
    protected static ?string $model = DoctorAppointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Appointments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Appointment Information')
                    ->schema([
                        Forms\Components\Select::make('doctor_id')
                            ->relationship('doctor', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Doctor'),
                        
                        Forms\Components\TextInput::make('full_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Full Name'),
                        
                        Forms\Components\TextInput::make('phone_number')
                            ->required()
                            ->tel()
                            ->maxLength(20)
                            ->label('Phone Number'),
                        
                        Forms\Components\DatePicker::make('preferred_date')
                            ->required()
                            ->minDate(now())
                            ->label('Preferred Date'),
                        
                        // Forms\Components\Select::make('preferred_time')
                        //     ->options([
                        //         '09:00' => '09:00 AM',
                        //         '10:00' => '10:00 AM',
                        //         '11:00' => '11:00 AM',
                        //         '12:00' => '12:00 PM',
                        //         '14:00' => '02:00 PM',
                        //         '15:00' => '03:00 PM',
                        //         '16:00' => '04:00 PM',
                        //         '17:00' => '05:00 PM',
                        //     ])
                        //     ->nullable()
                        //     ->label('Preferred Time'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->rows(3)
                            ->nullable()
                            ->label('Patient Message'),
                        
                        Forms\Components\Select::make('status')
                            ->options(DoctorAppointment::getStatusOptions())
                            ->required()
                            ->default('pending')
                            ->label('Status'),
                        
                        Forms\Components\Textarea::make('admin_notes')
                            ->rows(3)
                            ->nullable()
                            ->label('Admin Notes'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('doctor.name')
                    ->sortable()
                    ->searchable()
                    ->label('Doctor'),
                
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->label('Patient Name'),
                
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable()
                    ->label('Phone'),
                
                Tables\Columns\TextColumn::make('preferred_date')
                    ->date()
                    ->sortable()
                    ->label('Preferred Date'),
                
                // Tables\Columns\TextColumn::make('preferred_time')
                //     ->label('Preferred Time'),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'danger' => 'cancelled',
                        'primary' => 'completed',
                    ])
                    ->label('Status'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Booked At'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('doctor')
                    ->relationship('doctor', 'name'),
                
                Tables\Filters\SelectFilter::make('status')
                    ->options(DoctorAppointment::getStatusOptions()),
                
                Tables\Filters\Filter::make('preferred_date')
                    ->form([
                        Forms\Components\DatePicker::make('from_date'),
                        Forms\Components\DatePicker::make('to_date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('preferred_date', '>=', $date),
                            )
                            ->when(
                                $data['to_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('preferred_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctorAppointments::route('/'),
            'view' => Pages\ViewDoctorAppointment::route('/{record}'),
        ];
    }
}
