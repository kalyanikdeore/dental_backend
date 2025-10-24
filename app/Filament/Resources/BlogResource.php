<?php
// app/Filament/Resources/BlogResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
      protected static ?string $navigationGroup = 'Blog Page ';
    protected static ?string $navigationLabel = 'Blog  ';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Blog Post Details')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Forms\Components\Textarea::make('excerpt')
                        ->required()
                        ->rows(3)
                        ->maxLength(500),
                    Forms\Components\RichEditor::make('content')
                        ->required()
                        ->columnSpanFull()
                        ->fileAttachmentsDirectory('blogs/content')
                        ->toolbarButtons([
                            'blockquote', 'bold', 'bulletList', 'codeBlock', 'h2', 'h3', 
                            'italic', 'link', 'orderedList', 'redo', 'strike', 'underline', 'undo',
                        ]),
                ]),

            Forms\Components\Section::make('Media & Metadata')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Featured Image')
                        ->image()
                        ->directory('blogs/images')
                        ->visibility('public')
                        ->preserveFilenames()
                        ->maxSize(2048)
                        ->required()
                        ->helperText('Upload featured image (Max: 2MB)'),
                    Forms\Components\TextInput::make('category')
                        ->required(),
                    Forms\Components\TextInput::make('read_time')
                        ->required()
                        ->default('5 min read')
                        ->maxLength(50),
                ])->columns(2),

            Forms\Components\Section::make('Author Information')
                ->schema([
                    Forms\Components\TextInput::make('author')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('author_role')
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('author_image')
                        ->image()
                        ->directory('authors')
                        ->visibility('public')
                        ->avatar()
                        ->maxSize(1024)
                        ->helperText('Upload author photo (Max: 1MB)'),
                ])->columns(3),

            Forms\Components\Section::make('Settings')
                ->schema([
                    Forms\Components\DatePicker::make('published_date')
                        ->required()
                        ->default(now()),
                    Forms\Components\TagsInput::make('tags')
                        ->separator(',')
                        ->nestedRecursiveRules(['max:255']),
                    Forms\Components\Toggle::make('is_published')
                        ->required()
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')->label('Featured Image')->disk('public'),
            Tables\Columns\TextColumn::make('title')->searchable()->limit(50),
            Tables\Columns\TextColumn::make('category')->searchable(),
            Tables\Columns\TextColumn::make('author')->searchable(),
            Tables\Columns\TextColumn::make('published_date')->date()->sortable(),
            Tables\Columns\IconColumn::make('is_published')->boolean(),
            Tables\Columns\TextColumn::make('views')->numeric()->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('category'),
            Tables\Filters\Filter::make('published')->query(fn ($query) => $query->where('is_published', true)),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
