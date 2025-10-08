<?php

namespace App\Filament\Resources\TreatmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    protected static ?string $recordTitleAttribute = 'h2';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('h2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}