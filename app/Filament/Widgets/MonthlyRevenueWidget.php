<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonthlyRevenueWidget extends BaseWidget
{
    protected static ?int $sort = -2;
    protected int | string | array $columnSpan = 1;

    protected function getColumns(): int
    {
        return 1;
    }

    protected function getStats(): array
    {
        $thisMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        $revenueThisMonth = Payment::where('status', 'confirmed')
            ->where('confirmed_at', '>=', $thisMonth)->sum('amount');
        $revenueLastMonth = Payment::where('status', 'confirmed')
            ->whereBetween('confirmed_at', [$lastMonth, $lastMonthEnd])->sum('amount');
        $revenueTrend = $revenueLastMonth > 0
            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
            : 0;

        return [
            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($revenueThisMonth, 0, ',', '.'))
                ->description($revenueTrend >= 0 ? "+{$revenueTrend}% dari bulan lalu" : "{$revenueTrend}% dari bulan lalu")
                ->descriptionIcon($revenueTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueTrend >= 0 ? 'success' : 'danger')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
