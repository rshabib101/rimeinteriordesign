<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Inquiry;
use App\Models\NewsletterSubscriber;
use App\Models\Post;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $newInquiries = Inquiry::where('status', 'New')->count();
        $wonDeals = Inquiry::where('status', 'Won')->count();

        return [
            Stat::make('Published Projects', Project::published()->count())
                ->description('Portfolio showcase items')
                ->descriptionIcon('heroicon-m-photo')
                ->color('warning'),

            Stat::make('New Leads', $newInquiries)
                ->description('Awaiting architect response')
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color($newInquiries > 0 ? 'danger' : 'success'),

            Stat::make('Won Consultations', $wonDeals)
                ->description('Converted turnkey clients')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Journal & Subscribers', NewsletterSubscriber::where('is_active', true)->count())
                ->description(Post::published()->count() . ' published articles')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),
        ];
    }
}

