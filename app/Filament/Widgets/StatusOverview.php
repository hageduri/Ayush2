<?php

namespace App\Filament\Widgets;

use App\Models\Indicator;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusOverview extends BaseWidget
{
    // protected function getStats(): array
    // {
    //     // if (request()->routeIs('filament.resources.verify-report.*')) {
    //         return [
    //             Stat::make('status', Indicator::count())
    //                 ->description('Number of indicators in the system')
    //                 ->descriptionIcon('heroicon-o-chart-bar'),
    //         ];
    //     // }

    //     // // Return an empty array if it's not on the VerifyReportResource
    //     // return [];
    // }
}
