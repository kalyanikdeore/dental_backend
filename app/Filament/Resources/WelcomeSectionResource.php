<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WelcomeSectionResource\Pages;
use App\Models\WelcomeSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WelcomeSectionResource extends Resource
{
    protected static ?string $model = WelcomeSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Textarea::make('description')->required(),
                Forms\Components\TagsInput::make('highlights')->required(),
                Forms\Components\TextInput::make('cta_text'),
                Forms\Components\TextInput::make('cta_link'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(50),
                Tables\Columns\TextColumn::make('cta_text'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWelcomeSections::route('/'),
            'edit' => Pages\EditWelcomeSection::route('/{record}/edit'),
        ];
    }
}