<?php

namespace App\Filament\Resources\VerifyReportResource\Widgets;

use App\Models\Indicator;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('status', Indicator::count())
                ->description('Number of indicators in the system')
                ->descriptionIcon('heroicon-o-chart-bar'),
        ];
    }
}
