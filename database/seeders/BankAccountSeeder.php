<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            [
                'bank_name' => 'BCA',
                'account_number' => '1234567890',
                'account_name' => 'JavaShop Indonesia',
                'is_active' => true,
            ],
            [
                'bank_name' => 'BNI',
                'account_number' => '0987654321',
                'account_name' => 'JavaShop Indonesia',
                'is_active' => true,
            ],
            [
                'bank_name' => 'BRI',
                'account_number' => '1122334455',
                'account_name' => 'JavaShop Indonesia',
                'is_active' => true,
            ],
        ];

        foreach ($banks as $bank) {
            BankAccount::updateOrCreate(
                ['bank_name' => $bank['bank_name'], 'account_number' => $bank['account_number']],
                $bank
            );
        }
    }
}
