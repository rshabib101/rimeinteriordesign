<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
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
 * Filament resource for managing services offered by Rime Interior.
 */
class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Service Info')
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

                    Forms\Components\Select::make('icon')
                        ->options([
                            'home'         => 'Home / Residential',
                            'briefcase'    => 'Briefcase / Office',
                            'layers'       => 'Layers / Modular Kitchen',
                            'moon'         => 'Moon / Bedroom & Living',
                            'box'          => 'Box / 3D Visualization',
                            'check-circle' => 'Check / Turnkey Fit-out',
                            'sparkles'     => 'Sparkles / Renovation',
                        ])
                        ->default('home'),

                    Forms\Components\Textarea::make('short_description')
                        ->rows(2)
                        ->maxLength(500),

                    Forms\Components\Textarea::make('short_description_bn')
                        ->label('Short Description (Bangla)')
                        ->rows(2)
                        ->maxLength(500),

                    Forms\Components\RichEditor::make('full_description')
                        ->label('Detailed Service Overview')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('starting_price_bdt')
                        ->label('Starting Price (BDT ৳)')
                        ->numeric()
                        ->prefix('৳'),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TagsInput::make('features')
                        ->label('Key Feature Highlights')
                        ->placeholder('Type feature and press Enter')
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('process_steps')
                        ->label('Service Execution Steps')
                        ->schema([
                            Forms\Components\TextInput::make('title')->required(),
                            Forms\Components\Textarea::make('description')->rows(2),
                        ])
                        ->columns(2)
                        ->columnSpanFull()
                        ->collapsible(),

                    Forms\Components\FileUpload::make('banner_upload')
                        ->label('Upload Banner Image')
                        ->disk('public')
                        ->directory('services')
                        ->image(),

                    Forms\Components\TextInput::make('banner_image')
                        ->label('Banner Image URL / Path')
                        ->maxLength(500),

                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured on Home'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
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
                    ->sortable(),

                Tables\Columns\TextColumn::make('starting_price_bdt')
                    ->label('Starting Price')
                    ->formatStateUsing(fn ($state) => $state ? '৳' . number_format((float) $state) : '—')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->reorderable('sort_order')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function mergeUploadedFiles(array $data): array
    {
        if (!empty($data['banner_upload'])) {
            $data['banner_image'] = $data['banner_upload'];
        }
        unset($data['banner_upload']);

        return $data;
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
