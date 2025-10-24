<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSectionResource\Pages;
use App\Models\HeroSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
        protected static ?string $navigationGroup = 'Home Page ';
    protected static ?string $navigationLabel = 'Hero Section  ';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hero Section Content')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('cta_highlight')
                            ->required()
                            ->label('CTA Highlight Text'),

                        Forms\Components\TextInput::make('appointment_link')
                            ->required()
                            ->url()
                            ->label('Appointment Link'),
                    ]),

                Forms\Components\Section::make('Video Settings')
                    ->schema([
                        Forms\Components\FileUpload::make('video_file')
                            ->label('Upload Video')
                            ->directory('hero_videos') // stored in storage/app/public/hero_videos
                            ->disk('public')
                            ->acceptedFileTypes(['video/mp4', 'video/mov', 'video/avi', 'video/webm'])
                            ->maxSize(51200) // up to 50MB
                            ->helperText('Upload a hero section video (Max 50MB)'),

                        Forms\Components\TextInput::make('video_url')
                            ->label('Video URL (optional)')
                            ->url()
                            ->nullable()
                            ->helperText('If uploading, this can be left empty.'),
                    ]),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Activating this will deactivate other sections.')
                            ->default(false),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('cta_highlight')->label('CTA Text'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('activate')
                    ->label('Activate')
                    ->icon('heroicon-o-check')
                    ->action(fn (HeroSection $record) => $record->update(['is_active' => true]))
                    ->color('success')
                    ->visible(fn (HeroSection $record): bool => !$record->is_active),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroSections::route('/'),
            'create' => Pages\CreateHeroSection::route('/create'),
            'edit' => Pages\EditHeroSection::route('/{record}/edit'),
        ];
    }
}
