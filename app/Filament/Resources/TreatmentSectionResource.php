<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TreatmentSectionResource\Pages;
use App\Models\TreatmentSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TreatmentSectionResource extends Resource
{
    protected static ?string $model = TreatmentSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
          protected static ?string $navigationGroup = 'Treatment page ';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('treatment_id')
                    ->relationship('treatment', 'h1')
                    ->required(),
                Forms\Components\TextInput::make('h2')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('content')
                    ->rows(3),
                Forms\Components\TextInput::make('list_title')
                    ->maxLength(255),
                Forms\Components\Repeater::make('list_items')
                    ->schema([
                        Forms\Components\TextInput::make('item')
                            ->required(),
                    ]),
                Forms\Components\Repeater::make('subsections')
                    ->schema([
                        Forms\Components\TextInput::make('h3')
                            ->required(),
                        Forms\Components\Textarea::make('content')
                            ->required(),
                    ]),
                Forms\Components\Repeater::make('ordered_list')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->required(),
                    ]),
                Forms\Components\Textarea::make('note')
                    ->rows(2),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('treatment-sections'),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('treatment.h1')
                    ->sortable(),
                Tables\Columns\TextColumn::make('h2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTreatmentSections::route('/'),
            'create' => Pages\CreateTreatmentSection::route('/create'),
            'edit' => Pages\EditTreatmentSection::route('/{record}/edit'),
        ];
    }
}