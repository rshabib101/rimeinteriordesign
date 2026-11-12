<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Models\Inquiry;
use App\Models\Service;
use App\Support\MediaHelper;
use Filament\Actions\Action;
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

/**
 * Filament resource for managing client inquiries and consultation bookings.
 */
class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-inbox';

    protected static string | \UnitEnum | null $navigationGroup = 'CRM';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Inquiries & Leads';

    public static function getNavigationBadge(): ?string
    {
        $count = Inquiry::where('status', 'New')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Contact Details')
                ->schema([
                    Forms\Components\TextInput::make('booking_number')
                        ->disabled()
                        ->dehydrated(false)
                        ->placeholder('Auto-generated'),

                    Forms\Components\TextInput::make('name')->required()->maxLength(255),
                    Forms\Components\TextInput::make('email')->email()->required(),
                    Forms\Components\TextInput::make('phone')->tel()->required()->maxLength(30),
                ])
                ->columns(2),

            Section::make('Project Details')
                ->schema([
                    Forms\Components\Select::make('service_id')
                        ->label('Service Requested')
                        ->options(Service::pluck('title', 'id'))
                        ->searchable(),

                    Forms\Components\Select::make('property_type')
                        ->options([
                            'Apartment'  => 'Apartment',
                            'Duplex'     => 'Duplex',
                            'Penthouse'  => 'Penthouse',
                            'Villa'      => 'Villa / House',
                            'Office'     => 'Office',
                            'Showroom'   => 'Retail / Showroom',
                            'Restaurant' => 'Restaurant / Cafe',
                        ])
                        ->default('Apartment'),

                    Forms\Components\TextInput::make('area_sqft')
                        ->label('Area (sq ft)')
                        ->numeric(),

                    Forms\Components\TextInput::make('budget_range')
                        ->label('Budget Range (BDT)')
                        ->maxLength(100),

                    Forms\Components\DatePicker::make('preferred_date')
                        ->label('Preferred Consultation Date'),

                    Forms\Components\TextInput::make('preferred_time')
                        ->label('Preferred Time Slot')
                        ->maxLength(50),

                    Forms\Components\TextInput::make('floor_plan_path')
                        ->label('Uploaded Floor Plan Path')
                        ->disabled()
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('message')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('CRM Status & Internal Notes')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'New'       => 'New',
                            'Contacted' => 'Contacted',
                            'Quoted'    => 'Quoted',
                            'Won'       => 'Won',
                            'Lost'      => 'Lost',
                        ])
                        ->default('New')
                        ->required(),

                    Forms\Components\Textarea::make('admin_notes')
                        ->label('Internal Architect Notes')
                        ->rows(3),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')
                    ->label('Ref #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('service.title')
                    ->label('Service')
                    ->badge()
                    ->color('info')
                    ->placeholder('General'),

                Tables\Columns\TextColumn::make('property_type')
                    ->label('Property'),

                Tables\Columns\TextColumn::make('budget_range')
                    ->label('Budget'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'New'       => 'warning',
                        'Contacted' => 'info',
                        'Quoted'    => 'primary',
                        'Won'       => 'success',
                        'Lost'      => 'danger',
                        default     => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'New'       => 'New',
                        'Contacted' => 'Contacted',
                        'Quoted'    => 'Quoted',
                        'Won'       => 'Won',
                        'Lost'      => 'Lost',
                    ]),

                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Service')
                    ->options(Service::pluck('title', 'id')),
            ])
            ->actions([
                Action::make('floor_plan')
                    ->label('Plan')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (Inquiry $record): ?string => MediaHelper::url($record->floor_plan_path), shouldOpenInNewTab: true)
                    ->visible(fn (Inquiry $record): bool => filled($record->floor_plan_path)),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListInquiries::route('/'),
            'create' => Pages\CreateInquiry::route('/create'),
            'edit'   => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }
}
