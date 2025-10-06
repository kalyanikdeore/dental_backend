<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form as FormsForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table as TablesTable;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(FormsForm $form): FormsForm
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Textarea::make('description')->required(),
                Forms\Components\TextInput::make('icon')->nullable(),
                Forms\Components\TextInput::make('path')->nullable(),
            ]);
    }

    public static function table(TablesTable $table): TablesTable
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('path'),
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
            'index' => Pages\ListServices::route('/'),
            'edit' => Pages\EditService::route('/{record}/edit'),
            'create' => Pages\CreateService::route('/create'),
        ];
    }
}