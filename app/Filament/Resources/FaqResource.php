<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
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

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('FAQ')
                ->schema([
                    Forms\Components\Select::make('category')
                        ->options([
                            'general' => 'General',
                            'pricing' => 'Pricing',
                            'process' => 'Process',
                            'turnkey' => 'Turnkey',
                            'design'  => 'Design',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                    Forms\Components\TextInput::make('question')->required()->maxLength(500)->columnSpanFull(),
                    Forms\Components\TextInput::make('question_bn')->label('Question (Bangla)')->maxLength(500)->columnSpanFull(),
                    Forms\Components\Textarea::make('answer')->required()->rows(5)->columnSpanFull(),
                    Forms\Components\Textarea::make('answer_bn')->label('Answer (Bangla)')->rows(5)->columnSpanFull(),
                    Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')->limit(60)->searchable(),
                Tables\Columns\TextColumn::make('category')->badge()->color('info'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->reorderable('sort_order')
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit'   => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
