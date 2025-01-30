<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tariff;

class TariffSeeder extends Seeder
{

    public function run(): void
    {
        $tariffs = [
            ['name' => 'Fixed Charges', 'amount' => 1000, 'category_id'  => 1, 'date' => '2024-01-01'],
            ['name' => 'Services', 'amount' => 500, 'category_id'  => 1, 'date' => '2024-02-01'],
        ];

        foreach ($tariffs as $tariff) {
            Tariff::create($tariff);
        }
    }
}
