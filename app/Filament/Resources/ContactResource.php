<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationGroup = 'Clinic Management';
    protected static ?string $navigationLabel = 'Contacts';
    protected static ?string $pluralModelLabel = 'Contacts';
    protected static ?string $modelLabel = 'Contact';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Clinic Name'),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->label('Slug'),

                Forms\Components\Textarea::make('address')
                    ->required()
                    ->rows(3)
                    ->label('Address'),

                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->tel()
                    ->maxLength(20)
                    ->label('Primary Phone'),

                Forms\Components\TextInput::make('secondary_phone')
                    ->tel()
                    ->maxLength(20)
                    ->label('Secondary Phone'),

                Forms\Components\TextInput::make('hours')
                    ->required()
                    ->maxLength(255)
                    ->label('Operating Hours'),

                Forms\Components\Textarea::make('map_embed')
                    ->required()
                    ->rows(3)
                    ->label('Google Map Embed Code')
                    ->placeholder('<iframe src="..."></iframe>'),

                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255)
                    ->label('Email Address'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Clinic Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Primary Phone'),

                Tables\Columns\TextColumn::make('secondary_phone')
                    ->label('Secondary Phone')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),

                Tables\Columns\TextColumn::make('hours')
                    ->label('Operating Hours')
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, h:i A')
                    ->sortable()
                    ->label('Created'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y, h:i A')
                    ->sortable()
                    ->label('Updated'),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_secondary_phone')
                    ->label('Has Secondary Phone')
                    ->query(fn ($query) => $query->whereNotNull('secondary_phone')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            // Add relation managers if you have related models later
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
          
        ];
    }
}
