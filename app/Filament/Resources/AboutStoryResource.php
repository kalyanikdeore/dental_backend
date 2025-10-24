<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutStoryResource\Pages;
use App\Models\AboutStory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class AboutStoryResource extends Resource
{
    protected static ?string $model = AboutStory::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    
       protected static ?string $navigationGroup = 'About  Page ';
    protected static ?string $navigationLabel = 'About us ';
    

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required()->maxLength(255),
            Forms\Components\Textarea::make('description')->required(),
            Forms\Components\FileUpload::make('image')->image()->required(),
            Forms\Components\TextInput::make('order')->numeric()->default(0),
            Forms\Components\Toggle::make('visible')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('order')->sortable(),
                Tables\Columns\IconColumn::make('visible')->boolean(),
                Tables\Columns\ImageColumn::make('image'),
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
            'index' => Pages\ListAboutStories::route('/'),
            'create' => Pages\CreateAboutStory::route('/create'),
            'edit' => Pages\EditAboutStory::route('/{record}/edit'),
        ];
    }
}
