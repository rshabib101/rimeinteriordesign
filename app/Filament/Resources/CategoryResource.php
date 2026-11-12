<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
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

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    protected static string | \UnitEnum | null $navigationGroup = 'Portfolio';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Category')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (?string $state, callable $set, string $operation) => $operation === 'create' && $state ? $set('slug', Str::slug($state)) : null),
                    Forms\Components\TextInput::make('name_bn')->label('Name (Bangla)')->maxLength(255),
                    Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(255),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                    Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
                    Forms\Components\TextInput::make('image')->label('Image URL / Path')->maxLength(500)->columnSpanFull(),
                    Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('projects_count')->label('Projects')->counts('projects'),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->reorderable('sort_order')
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
