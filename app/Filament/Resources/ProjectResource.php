<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Category;
use App\Models\Project;
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
 * Filament resource for managing interior design projects (portfolio).
 */
class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-photo';

    protected static string | \UnitEnum | null $navigationGroup = 'Portfolio';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Project Details')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (?string $state, callable $set, string $operation) => $operation === 'create' && $state ? $set('slug', Str::slug($state)) : null)
                        ->columnSpan(1),

                    Forms\Components\TextInput::make('title_bn')
                        ->label('Title (Bangla)')
                        ->maxLength(255)
                        ->columnSpan(1),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\Select::make('category_id')
                        ->label('Category')
                        ->options(Category::pluck('name', 'id'))
                        ->required()
                        ->searchable(),

                    Forms\Components\Select::make('room_type')
                        ->options([
                            'living'     => 'Living Room',
                            'bedroom'    => 'Bedroom',
                            'kitchen'    => 'Kitchen',
                            'office'     => 'Office',
                            'bathroom'   => 'Bathroom',
                            'dining'     => 'Dining Room',
                            'full_house' => 'Full Residence',
                        ])
                        ->required(),

                    Forms\Components\Select::make('style')
                        ->options([
                            'Modern'       => 'Modern',
                            'Minimal'      => 'Minimal',
                            'Classic'      => 'Classic',
                            'Scandinavian' => 'Scandinavian',
                            'Contemporary' => 'Contemporary',
                            'Japandi'      => 'Japandi',
                        ])
                        ->required(),
                ])
                ->columns(2),

            Section::make('Project Information & 3D Asset')
                ->schema([
                    Forms\Components\TextInput::make('area_sqft')
                        ->label('Area (sq ft)')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('location')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('duration')
                        ->maxLength(100)
                        ->placeholder('e.g. 4 Months'),

                    Forms\Components\TextInput::make('completion_year')
                        ->numeric()
                        ->minValue(2000)
                        ->maxValue(2035),

                    Forms\Components\TextInput::make('client_name')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('model_3d_path')
                        ->label('3D Model URL or Path (.glb / .gltf)')
                        ->maxLength(500)
                        ->placeholder('https://... or upload below'),

                    Forms\Components\FileUpload::make('model_3d_upload')
                        ->label('Upload 3D Model (.glb / .gltf)')
                        ->disk('public')
                        ->directory('projects/models')
                        ->acceptedFileTypes(['model/gltf-binary', 'model/gltf+json', 'application/octet-stream', '.glb', '.gltf'])
                        ->maxSize(25600)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Description')
                ->schema([
                    Forms\Components\Textarea::make('summary')
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('description')
                        ->columnSpanFull(),
                ]),

            Section::make('Images & Before/After')
                ->schema([
                    Forms\Components\FileUpload::make('cover_upload')
                        ->label('Upload Cover Image')
                        ->disk('public')
                        ->directory('projects/covers')
                        ->image()
                        ->imageEditor(),

                    Forms\Components\TextInput::make('cover_image')
                        ->label('Cover Image URL / Saved Path')
                        ->maxLength(500),

                    Forms\Components\FileUpload::make('before_upload')
                        ->label('Upload Before Image')
                        ->disk('public')
                        ->directory('projects/before-after')
                        ->image(),

                    Forms\Components\TextInput::make('before_image')
                        ->label('Before Image URL / Saved Path')
                        ->maxLength(500),

                    Forms\Components\FileUpload::make('after_upload')
                        ->label('Upload After Image')
                        ->disk('public')
                        ->directory('projects/before-after')
                        ->image(),

                    Forms\Components\TextInput::make('after_image')
                        ->label('After Image URL / Saved Path')
                        ->maxLength(500),

                    Forms\Components\FileUpload::make('gallery_uploads')
                        ->label('Upload Gallery Photos')
                        ->disk('public')
                        ->directory('projects/gallery')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->columnSpanFull(),

                    Forms\Components\TagsInput::make('gallery_images')
                        ->label('Gallery Image URLs / Paths')
                        ->placeholder('Paste image URL and press Enter')
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('SEO & Publication')
                ->schema([
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured on Home Page'),

                    Forms\Components\Toggle::make('is_published')
                        ->label('Published')
                        ->default(true),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('meta_title')
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('meta_description')
                        ->rows(2)
                        ->maxLength(500)
                        ->columnSpanFull(),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->width(60)
                    ->height(45)
                    ->disk('public'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(35),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),

                Tables\Columns\TextColumn::make('style')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('area_sqft')
                    ->label('Area (sqft)')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),

                Tables\Columns\TextColumn::make('completion_year')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(Category::pluck('name', 'id')),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),

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
            ->defaultSort('sort_order');
    }

    /**
     * Merge uploaded files into standard database image/3D columns.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function mergeUploadedFiles(array $data): array
    {
        if (!empty($data['cover_upload'])) {
            $data['cover_image'] = $data['cover_upload'];
        }
        if (!empty($data['before_upload'])) {
            $data['before_image'] = $data['before_upload'];
        }
        if (!empty($data['after_upload'])) {
            $data['after_image'] = $data['after_upload'];
        }
        if (!empty($data['model_3d_upload'])) {
            $data['model_3d_path'] = $data['model_3d_upload'];
        }
        if (!empty($data['gallery_uploads']) && is_array($data['gallery_uploads'])) {
            $existing = is_array($data['gallery_images'] ?? null) ? $data['gallery_images'] : [];
            $data['gallery_images'] = array_values(array_unique(array_merge($existing, $data['gallery_uploads'])));
        }

        unset(
            $data['cover_upload'],
            $data['before_upload'],
            $data['after_upload'],
            $data['model_3d_upload'],
            $data['gallery_uploads']
        );

        return $data;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
