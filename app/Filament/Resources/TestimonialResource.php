<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
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

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Client')
                ->schema([
                    Forms\Components\TextInput::make('client_name')->required()->maxLength(255),
                    Forms\Components\TextInput::make('client_designation')->maxLength(255),
                    Forms\Components\TextInput::make('client_avatar')->label('Avatar URL / Path')->maxLength(500),
                    Forms\Components\TextInput::make('project_name')->maxLength(255),
                    Forms\Components\Select::make('rating')
                        ->options([1 => '1 Star', 2 => '2 Stars', 3 => '3 Stars', 4 => '4 Stars', 5 => '5 Stars'])
                        ->default(5),
                ])
                ->columns(2),

            Section::make('Quote')
                ->schema([
                    Forms\Components\Textarea::make('quote')->required()->rows(4)->columnSpanFull(),
                    Forms\Components\Textarea::make('quote_bn')->label('Quote (Bangla)')->rows(4)->columnSpanFull(),
                    Forms\Components\Toggle::make('is_featured')->label('Featured')->default(true),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('project_name')->limit(30),
                Tables\Columns\TextColumn::make('rating')->badge()->color('warning'),
                Tables\Columns\IconColumn::make('is_featured')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->reorderable('sort_order')
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit'   => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
