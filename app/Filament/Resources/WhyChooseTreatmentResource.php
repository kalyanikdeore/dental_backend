<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhyChooseTreatmentResource\Pages;
use App\Models\WhyChooseTreatment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WhyChooseTreatmentResource extends Resource
{
    protected static ?string $model = WhyChooseTreatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
          protected static ?string $navigationGroup = 'Treatment page ';

    protected static ?string $navigationLabel = 'Why Choose Items';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Why Choose Item Information')
                    ->schema([
                        Forms\Components\Select::make('treatment_id')
                            ->relationship('treatment', 'h1')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Forms\Components\TextInput::make('icon')
                            ->maxLength(255)
                            ->helperText('Use Heroicon name or icon class'),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(3)
                            ->maxLength(500),
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('treatment.h1')
                    ->sortable()
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('treatment')
                    ->relationship('treatment', 'h1')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
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
            'index' => Pages\ListWhyChooseTreatments::route('/'),
            'create' => Pages\CreateWhyChooseTreatment::route('/create'),
            'edit' => Pages\EditWhyChooseTreatment::route('/{record}/edit'),
        ];
    }
}