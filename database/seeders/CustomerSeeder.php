<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'first_name' => 'Cliff',
                'last_name' => 'Levai',
                'phone' => '144155166',
                'email' => 'clifflevai@gmail.com',
                'category_id' => 1,
                'contract' => 12300056,
                'date' => '2024-01-01'
            ],
            [
                'first_name' => 'Oliver',
                'last_name' => 'Levai',
                'phone' => '123123123',
                'email' => 'oliver@gmail.com',
                'category_id' => 2,
                'contract' => 12300057,
                'date' => '2024-02-01'
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
