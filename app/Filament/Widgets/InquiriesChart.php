<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Inquiry;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class InquiriesChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Consultations & Inquiries (Last 6 Months)';

    protected ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $labels = [];
        $counts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');
            $counts[] = Inquiry::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Inquiries',
                    'data'            => $counts,
                    'borderColor'     => '#B8894D',
                    'backgroundColor' => 'rgba(184, 137, 77, 0.25)',
                    'fill'            => true,
                    'tension'         => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

