<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Residential', 'tariff' => 600],
            ['name' => 'Commercial', 'tariff' => 3000],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
