<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChartWidget extends ChartWidget
{
    protected ?string $heading = 'Pendapatan 6 Bulan Terakhir';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected ?string $maxHeight = '50vh';

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));

        $labels = $months->map(fn ($m) => $m->translatedFormat('M Y'))->toArray();

        $data = $months->map(function (Carbon $month) {
            return (float) Payment::where('status', 'confirmed')
                ->whereYear('confirmed_at', $month->year)
                ->whereMonth('confirmed_at', $month->month)
                ->sum('amount');
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $data,
                    'borderColor' => '#B8924A',
                    'backgroundColor' => 'rgba(184, 146, 74, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
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
