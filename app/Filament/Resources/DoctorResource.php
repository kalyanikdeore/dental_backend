<?php
// app/Filament/Resources/DoctorResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Arr;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Doctors Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Doctor Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('experience')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('specialization')
                            ->required()
                            ->rows(3),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(3),
                    ])->columns(1),

                Forms\Components\Section::make('Achievements')
                    ->schema([
                        Forms\Components\Repeater::make('achievements')
                            ->schema([
                                Forms\Components\TextInput::make('achievement')
                                    ->label('Achievement')
                                    ->required()
                                    ->maxLength(500),
                            ])
                            ->defaultItems(1)
                            ->reorderable(true)
                            ->columnSpanFull()
                            ->helperText('Add key achievements and accomplishments'),
                    ]),

                Forms\Components\Section::make('Media & SEO')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('doctors')
                            ->disk('public')
                            ->required()
                            ->helperText('Image will be stored in public/uploads/doctors directory'),
                        Forms\Components\TextInput::make('alt_text')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Alt text for SEO and accessibility'),
                        Forms\Components\Textarea::make('seo_keywords')
                            ->required()
                            ->rows(2)
                            ->helperText('Separate keywords with commas'),
                    ])->columns(1),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->helperText('Show/Hide this doctor on the website'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('experience')
                    ->limit(20),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->alignCenter(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}