<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Models\TeamMember;
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

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-group';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Team Member')
                ->schema([
                    Forms\Components\TextInput::make('name')->required()->maxLength(255),
                    Forms\Components\TextInput::make('role')->required()->maxLength(255),
                    Forms\Components\TextInput::make('role_bn')->label('Role (Bangla)')->maxLength(255),
                    Forms\Components\FileUpload::make('photo_upload')
                        ->label('Upload Photo')
                        ->disk('public')
                        ->directory('team')
                        ->image(),
                    Forms\Components\TextInput::make('photo')->label('Photo URL / Path')->maxLength(500),
                    Forms\Components\Textarea::make('bio')->rows(3)->columnSpanFull(),
                    Forms\Components\TextInput::make('linkedin_url')->label('LinkedIn URL')->url(),
                    Forms\Components\TextInput::make('instagram_url')->label('Instagram URL')->url(),
                    Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('role')->limit(40),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->reorderable('sort_order')
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function mergeUploadedFiles(array $data): array
    {
        if (!empty($data['photo_upload'])) {
            $data['photo'] = $data['photo_upload'];
        }
        unset($data['photo_upload']);

        return $data;
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit'   => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
