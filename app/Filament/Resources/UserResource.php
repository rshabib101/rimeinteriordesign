<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
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
use Illuminate\Support\Facades\Hash;

/**
 * Manage staff accounts with Admin/Editor roles (accessible to Admins only).
 */
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-check';

    protected static string | \UnitEnum | null $navigationGroup = 'Settings & Access';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Team Accounts';

    public static function canViewAny(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Account Details')
                ->schema([
                    Forms\Components\TextInput::make('name')->required()->maxLength(255),
                    Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                    Forms\Components\Select::make('role')
                        ->options([
                            'admin'  => 'Admin (Full Access)',
                            'editor' => 'Editor (Content & CRM)',
                        ])
                        ->default('editor')
                        ->required(),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->maxLength(255),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (?string $state): string => $state === 'admin' ? 'warning' : 'info'),
                Tables\Columns\TextColumn::make('created_at')->date('d M Y')->sortable(),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

