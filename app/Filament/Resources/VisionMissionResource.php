<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisionMissionResource\Pages;
use App\Models\VisionMission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class VisionMissionResource extends Resource
{
    protected static ?string $model = VisionMission::class;
    protected static ?string $navigationIcon = 'heroicon-o-eye';
         protected static ?string $navigationGroup = 'About  Page ';
  
    protected static ?string $navigationLabel = 'Vision & Mission';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('vision')->required(),
            Forms\Components\Textarea::make('mission')->required(),
            Forms\Components\Toggle::make('visible')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vision')->limit(50),
                Tables\Columns\TextColumn::make('mission')->limit(50),
                Tables\Columns\IconColumn::make('visible')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisionMissions::route('/'),
            'create' => Pages\CreateVisionMission::route('/create'),
            'edit' => Pages\EditVisionMission::route('/{record}/edit'),
        ];
    }
}
