<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $thisMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        // Pending Payments
        $pendingCount = Payment::where('status', 'pending')->count();

        // Orders
        $ordersThisMonth = Order::where('created_at', '>=', $thisMonth)->count();
        $ordersLastMonth = Order::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        // Products
        $activeProducts = Product::active()->count();

        // Customers
        $totalCustomers = User::where('role', 'customer')->count();

        return [
            Stat::make('Pembayaran Menunggu', $pendingCount)
                ->description($pendingCount > 0 ? 'Perlu konfirmasi segera' : 'Semua sudah dikonfirmasi')
                ->descriptionIcon($pendingCount > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($pendingCount > 0 ? 'warning' : 'success')
                ->url($pendingCount > 0 ? '/admin/payments?tableFilters[status][value]=pending' : null),

            Stat::make('Pesanan Bulan Ini', $ordersThisMonth)
                ->description($ordersLastMonth > 0 ? "vs {$ordersLastMonth} bulan lalu" : 'Bulan pertama')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),

            Stat::make('Produk Aktif', $activeProducts)
                ->description('Produk yang ditampilkan')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),

            Stat::make('Total Pelanggan', $totalCustomers)
                ->description('Pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
