<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageSettingResource\Pages;
use App\Filament\Resources\PageSettingResource\RelationManagers;
use App\Models\PageSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageSettingResource extends Resource
{
    protected static ?string $model = PageSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page Information')
                    ->schema([
                        Forms\Components\TextInput::make('page_title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('page_description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('seo_keywords')
                            ->required()
                            ->rows(2)
                            ->helperText('Separate keywords with commas')
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Call to Action Section')
                    ->schema([
                        Forms\Components\TextInput::make('cta_title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('cta_description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page_title')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageSettings::route('/'),
            'create' => Pages\CreatePageSetting::route('/create'),
            'edit' => Pages\EditPageSetting::route('/{record}/edit'),
        ];
    }
}