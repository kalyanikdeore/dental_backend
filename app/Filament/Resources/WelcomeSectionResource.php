<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WelcomeSectionResource\Pages;
use App\Models\WelcomeSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class WelcomeSectionResource extends Resource
{
    protected static ?string $model = WelcomeSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
     protected static ?string $navigationGroup = 'Home Page ';
    protected static ?string $navigationLabel = 'About us ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->rows(3),
                
                Forms\Components\TagsInput::make('highlights')
                    ->required(),
                
                Forms\Components\TextInput::make('cta_text')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('cta_link')
                    ->maxLength(255),
                
                Forms\Components\FileUpload::make('image_1')
                    ->label('Image 1')
                    ->image()
                    ->directory('welcome-section')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->helperText('Upload first image for welcome section'),
                
                Forms\Components\FileUpload::make('image_2')
                    ->label('Image 2')
                    ->image()
                    ->directory('welcome-section')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->helperText('Upload second image for welcome section'),
                
                Forms\Components\FileUpload::make('image_3')
                    ->label('Image 3')
                    ->image()
                    ->directory('welcome-section')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->helperText('Upload third image for welcome section'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('cta_text')
                    ->searchable(),
                
                Tables\Columns\ImageColumn::make('image_1')
                    ->label('Image 1')
                    ->disk('public'),
                
                Tables\Columns\ImageColumn::make('image_2')
                    ->label('Image 2')
                    ->disk('public'),
                
                Tables\Columns\ImageColumn::make('image_3')
                    ->label('Image 3')
                    ->disk('public'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Tables\Actions\DeleteAction $action, WelcomeSection $record) {
                        // Delete images when deleting the record
                        if ($record->image_1) {
                            Storage::disk('public')->delete($record->image_1);
                        }
                        if ($record->image_2) {
                            Storage::disk('public')->delete($record->image_2);
                        }
                        if ($record->image_3) {
                            Storage::disk('public')->delete($record->image_3);
                        }
                    }),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWelcomeSections::route('/'),
            'create' => Pages\CreateWelcomeSection::route('/create'),
            'edit' => Pages\EditWelcomeSection::route('/{record}/edit'),
        ];
    }
}