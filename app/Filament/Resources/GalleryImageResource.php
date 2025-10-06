<?php
// app/Filament/Resources/GalleryImageResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\GalleryImageResource\Pages;
use App\Models\GalleryImage;
use App\Models\GalleryCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Gallery';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->options(GalleryCategory::with('clinic')->get()->mapWithKeys(function ($category) {
                        return [$category->id => $category->clinic->name . ' - ' . $category->name];
                    }))
                    ->required()
                    ->searchable()
                    ->preload(),
                
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('gallery')
                    ->visibility('public')
                    ->maxSize(5120) // 5MB
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('800')
                    ->imageResizeTargetHeight('600')
                    ->imagePreviewHeight('200')
                    ->preserveFilenames() // Keep original filenames
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp']),
                
                Forms\Components\TextInput::make('alt_text')
                    ->label('Alt Text')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Description for the image (e.g., Aparna_bhalerao_Kids_Treatment)'),
                
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
                
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->size(100)
                    ->height(60)
                    ->extraImgAttributes(['class' => 'object-cover'])
                    ->url(fn ($record) => $record->image_url)
                    ->openUrlInNewTab(),
                
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('category.clinic.name')
                    ->label('Clinic')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('alt_text')
                    ->searchable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                
                Tables\Columns\TextColumn::make('image_url')
                    ->label('Image URL')
                    ->copyable()
                    ->copyMessage('URL copied!')
                    ->limit(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\SelectFilter::make('clinic')
                    ->relationship('category.clinic', 'name')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\Filter::make('active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('view_image')
                    ->url(fn ($record) => $record->image_url)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order');
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
            'index' => Pages\ListGalleryImages::route('/'),
            'create' => Pages\CreateGalleryImage::route('/create'),
            'edit' => Pages\EditGalleryImage::route('/{record}/edit'),
        ];
    }
}