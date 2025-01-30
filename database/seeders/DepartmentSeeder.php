<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'department_name' => 'meter', 
                'name' => 'Meters', 
                'role'  => 'manager'
            ],
            [
                'department_name' => 'tatiff', 
                'name' => 'Tatiff', 
                'role'  => 'manager'
            ],
            [
                'department_name' => 'invoices', 
                'name' => 'Invoices', 
                'role'  => 'manager'
            ],
            [
                'department_name' => 'customers', 
                'name' => 'Customers', 
                'role'  => 'manager'
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
