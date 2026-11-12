<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

/**
 * Filament resource for managing blog posts.
 */
class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Post Details')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (?string $state, callable $set, string $operation) => $operation === 'create' && $state ? $set('slug', Str::slug($state)) : null),

                    Forms\Components\TextInput::make('title_bn')
                        ->label('Title (Bangla)')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\Select::make('author_id')
                        ->label('Author')
                        ->options(User::pluck('name', 'id'))
                        ->default(auth()->id())
                        ->required()
                        ->searchable(),

                    Forms\Components\TextInput::make('category')
                        ->maxLength(100)
                        ->default('Design Philosophy')
                        ->placeholder('e.g. Design Philosophy'),

                    Forms\Components\TagsInput::make('tags')
                        ->placeholder('Add tags'),

                    Forms\Components\Textarea::make('excerpt')
                        ->rows(2)
                        ->maxLength(500)
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('content')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('cover_upload')
                        ->label('Upload Cover Image')
                        ->disk('public')
                        ->directory('blog')
                        ->image(),

                    Forms\Components\TextInput::make('cover_image')
                        ->label('Cover Image URL / Path')
                        ->maxLength(500),

                    Forms\Components\Toggle::make('is_published')
                        ->label('Published')
                        ->default(true),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Published At')
                        ->default(now()),

                    Forms\Components\TextInput::make('meta_title')
                        ->maxLength(255),

                    Forms\Components\Textarea::make('meta_description')
                        ->rows(2)
                        ->maxLength(500),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function mergeUploadedFiles(array $data): array
    {
        if (!empty($data['cover_upload'])) {
            $data['cover_image'] = $data['cover_upload'];
        }
        unset($data['cover_upload']);

        return $data;
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
