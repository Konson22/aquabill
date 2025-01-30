<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['size' => '3/4"', 'model' => 'Model A', 'manufactory' => 'Manufactory A', 'date' => '2024-01-01'],
            ['size' => '5/8"', 'model' => 'Model B', 'manufactory' => 'Manufactory B', 'date' => '2024-02-01'],
            ['size' => '1/2"', 'model' => 'Model C', 'manufactory' => 'Manufactory C', 'date' => '2024-01-01'],
            ['size' => '1"', 'model' => 'Model D', 'manufactory' => 'Manufactory D', 'date' => '2024-02-01'],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
