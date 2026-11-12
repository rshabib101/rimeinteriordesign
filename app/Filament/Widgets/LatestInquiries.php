<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Filament\Resources\InquiryResource;
use App\Models\Inquiry;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestInquiries extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Recent Consultation Leads';

    public function table(Table $table): Table
    {
        return $table
            ->query(Inquiry::query()->with('service')->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')->label('Ref #')->weight('bold'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('service.title')->label('Service')->placeholder('General'),
                Tables\Columns\TextColumn::make('budget_range')->label('Budget'),
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
                Tables\Columns\TextColumn::make('created_at')->since(),
            ])
            ->actions([
                Action::make('manage')
                    ->label('Open')
                    ->url(fn (Inquiry $record): string => InquiryResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}

