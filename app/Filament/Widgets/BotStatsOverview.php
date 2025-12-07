<?php

namespace App\Filament\Widgets;

use App\Models\BotHit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BotStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Поймано ботов', BotHit::count())
                ->description('Количество срабатываний ловушки')
                ->descriptionIcon('heroicon-m-bug-ant')
                ->color('danger')
                ->chart(BotHit::selectRaw('count(*) as count, date(created_at) as date')
                    ->groupBy('date')
                    ->pluck('count')
                    ->toArray()),
        ];
    }
}

