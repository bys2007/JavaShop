<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $vouchers = [
            [
                'code' => 'WELCOME10',
                'name' => 'Diskon Selamat Datang 10%',
                'type' => 'percentage',
                'value' => 10.00,
                'min_purchase' => 50000.00,
                'max_discount' => null,
                'quota' => 100,
                'used_count' => 0,
                'start_date' => now()->startOfYear(),
                'end_date' => now()->endOfYear(),
                'is_active' => true,
            ],
            [
                'code' => 'KOPI50',
                'name' => 'Potongan Rp 50.000',
                'type' => 'fixed',
                'value' => 50000.00,
                'min_purchase' => 200000.00,
                'max_discount' => null,
                'quota' => 50,
                'used_count' => 0,
                'start_date' => now()->startOfYear(),
                'end_date' => now()->endOfYear(),
                'is_active' => true,
            ],
            [
                'code' => 'JAVASHOP20',
                'name' => 'Diskon Special 20% (Max 100rb)',
                'type' => 'percentage',
                'value' => 20.00,
                'min_purchase' => 150000.00,
                'max_discount' => 100000.00,
                'quota' => 30,
                'used_count' => 0,
                'start_date' => now()->startOfYear(),
                'end_date' => now()->endOfYear(),
                'is_active' => true,
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::updateOrCreate(['code' => $voucher['code']], $voucher);
        }
    }
}
