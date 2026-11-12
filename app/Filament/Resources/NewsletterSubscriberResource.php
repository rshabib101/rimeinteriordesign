<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterSubscriberResource\Pages;
use App\Models\NewsletterSubscriber;
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

class NewsletterSubscriberResource extends Resource
{
    protected static ?string $model = NewsletterSubscriber::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-envelope';

    protected static string | \UnitEnum | null $navigationGroup = 'CRM';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Newsletter Subscribers';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Subscriber')
                ->schema([
                    Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                    Forms\Components\Toggle::make('is_active')->label('Subscribed')->default(true),
                    Forms\Components\TextInput::make('ip_address')->disabled(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('ip_address')->label('IP'),
                Tables\Columns\TextColumn::make('created_at')->label('Subscribed At')->dateTime('d M Y, H:i')->sortable(),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNewsletterSubscribers::route('/'),
            'create' => Pages\CreateNewsletterSubscriber::route('/create'),
            'edit'   => Pages\EditNewsletterSubscriber::route('/{record}/edit'),
        ];
    }
}

