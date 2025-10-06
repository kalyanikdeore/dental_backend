<?php
// app/Filament/Resources/WhyChooseUsPointResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\WhyChooseUsPointResource\Pages;
use App\Models\WhyChooseUsPoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WhyChooseUsPointResource extends Resource
{
    protected static ?string $model = WhyChooseUsPoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Doctors Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Point Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('point')
                           
                            ->rows(2)
                            ->maxLength(500),
                        Forms\Components\TextInput::make('icon')
                            ->maxLength(50)
                            ->helperText('Heroicon name (e.g., award, users, shield)'),
                    ])->columns(1),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('point')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('icon'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->query(fn ($query) => $query->where('is_active', true)),
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
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhyChooseUsPoints::route('/'),
            'create' => Pages\CreateWhyChooseUsPoint::route('/create'),
            'edit' => Pages\EditWhyChooseUsPoint::route('/{record}/edit'),
        ];
    }
}