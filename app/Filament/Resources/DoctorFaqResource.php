<?php
// app/Filament/Resources/DoctorFaqResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorFaqResource\Pages;
use App\Models\DoctorFaq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DoctorFaqResource extends Resource
{
    protected static ?string $model = DoctorFaq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Doctors Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('FAQ Information')
                    ->schema([
                        Forms\Components\Textarea::make('question')
                            ->required()
                            ->rows(2)
                            ->maxLength(500),
                        Forms\Components\Textarea::make('answer')
                            ->required()
                            ->rows(3)
                            ->maxLength(1000),
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
                Tables\Columns\TextColumn::make('question')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('answer')
                    ->limit(50)
                    ->searchable(),
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
            'index' => Pages\ListDoctorFaqs::route('/'),
            'create' => Pages\CreateDoctorFaq::route('/create'),
            'edit' => Pages\EditDoctorFaq::route('/{record}/edit'),
        ];
    }
}