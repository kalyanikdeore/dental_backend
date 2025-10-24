<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientSafetySectionResource\Pages;
use App\Models\PatientSafetySection;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Form;

class PatientSafetySectionResource extends Resource
{
    protected static ?string $model = PatientSafetySection::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    

    
  

       protected static ?string $navigationGroup = 'Patient Safety Page ';
    protected static ?string $navigationLabel = 'Patient Safety ';
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                            
                        Forms\Components\Select::make('icon_name')
                            ->required()
                            ->options([
                                'sterilization' => 'Sterilization',
                                'infection-control' => 'Infection Control',
                                'safe-environment' => 'Safe Environment',
                                'quality-materials' => 'Quality Materials',
                                'trained-staff' => 'Trained Staff',
                                'peace-of-mind' => 'Peace of Mind',
                            ])
                            ->searchable(),
                            
                        Forms\Components\Select::make('alignment')
                            ->required()
                            ->options([
                                'left' => 'Left Aligned',
                                'right' => 'Right Aligned',
                            ])
                            ->default('left'),
                            
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('icon_name')
                    ->badge()
                    ->color('success'),
                    
                Tables\Columns\TextColumn::make('alignment')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'left' => 'info',
                        'right' => 'warning',
                    }),
                    
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('alignment')
                    ->options([
                        'left' => 'Left Aligned',
                        'right' => 'Right Aligned',
                    ]),
                    
                Tables\Filters\TernaryFilter::make('is_active'),
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
            ->reorderable('order')
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatientSafetySections::route('/'),
            'create' => Pages\CreatePatientSafetySection::route('/create'),
            'edit' => Pages\EditPatientSafetySection::route('/{record}/edit'),
        ];
    }
}