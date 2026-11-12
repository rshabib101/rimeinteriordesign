<?php

declare(strict_types=1);

namespace App\Filament\Resources\InquiryResource\Pages;

use App\Filament\Resources\InquiryResource;
use App\Models\Inquiry;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListInquiries extends ListRecords
{
    protected static string $resource = InquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_csv')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(fn (): StreamedResponse => $this->exportCsv()),
            Actions\CreateAction::make(),
        ];
    }

    protected function exportCsv(): StreamedResponse
    {
        $filename = 'rime-inquiries-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Booking #', 'Name', 'Email', 'Phone', 'Service', 'Property Type',
                'Area (sq ft)', 'Budget Range', 'Preferred Date', 'Preferred Time', 'Status', 'Created At',
            ]);

            Inquiry::with('service')->orderByDesc('created_at')->chunk(200, function ($inquiries) use ($handle): void {
                foreach ($inquiries as $inq) {
                    fputcsv($handle, [
                        $inq->booking_number,
                        $inq->name,
                        $inq->email,
                        $inq->phone,
                        $inq->service?->title ?? 'General',
                        $inq->property_type,
                        $inq->area_sqft,
                        $inq->budget_range,
                        $inq->preferred_date?->format('Y-m-d'),
                        $inq->preferred_time,
                        $inq->status,
                        $inq->created_at?->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
