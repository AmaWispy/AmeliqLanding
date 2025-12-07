<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Всего заявок', Lead::count())
                ->description('За все время')
                ->descriptionIcon('heroicon-m-inbox-stack')
                ->color('primary'),
            
            Stat::make('Заявки сегодня', Lead::whereDate('created_at', today())->count())
                ->description('Новые за сегодня')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('За неделю', Lead::whereDate('created_at', '>=', now()->subDays(7))->count())
                ->description('За последние 7 дней')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}

