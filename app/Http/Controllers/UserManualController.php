<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserManualController extends Controller
{
    public function index(){
        $items = [
            [
                'id' => 'introduction', 
                'name' => 'Introduction', 
                'subcontent' => []
            ],
            [
                'id' => 'installation_setup',
                'name' => 'Installation & Setup', 
                'subcontent' => []
            ],
            [
                'id' => 'system_requirements', 
                'name' => 'System Requirements', 
                'subcontent' => []
            ],
            [
                'id' => 'getting_started', 
                'name' => 'Getting Started', 
            ],
            [
                'id' => 'dashboard', 
                'name' => 'Dashboard', 
                'subcontent' => []
            ],
            [
                'id' => 33, 
                'name' => 'Customers Management', 
                'subcontent' => [
                    ['id' => 'customers_overview', 'name' => 'Customers Page Overview'],
                    ['id' => 'add_new_customer', 'name' => 'Add new Customer'],
                    ['id' => 'view_customer_profile', 'name' => 'View Customer Profile'],
                ]
            ],
            [
                'id' => 3, 
                'name' => 'Customer Profile', 
                'subcontent' => [
                    ['id' => 'customers_profile_overview', 'name' => 'Customers Overview'],
                    ['id' => 'customer_address_information', 'name' => 'Address Information'],
                    ['id' => 'edit_customer', 'name' => 'Edit Customer'],
                    ['id' => 'customer_invoices', 'name' => 'Invoices'],
                    ['id' => 'customer_one_time_invoices', 'name' => 'One-time Invoices'],
                    ['id' => 'customer_readings', 'name' => 'Meter Readings'],
                    ['id' => 'customer_meters', 'name' => 'Meters and History'],
                    ['id' => 'customer_meters_update', 'name' => 'Update/Replace Meter'],
                ]
            ],
            [
                'id' => 4, 
                'name' => 'Tariffs', 
                'content' => 'Manage tariffs for your system.', 
                'subcontent' => [
                    ['id' => 'add_category', 'name' => 'Add Category'],
                    ['id' => 'monthly_charges', 'name' => 'Monthly Charges']
                ]
            ],
            [
                'id' => 'billing_report', 
                'name' => 'Billing Reports', 
                'subcontent' => []
            ],
            [
                'id' => 'meters_management', 
                'name' => 'Meters', 
                'subcontent' => []
            ],
            [
                'id' => 'analytics', 
                'name' => 'Analytics', 
                'subcontent' => []
            ],
        ];
        
        return view('documentation.index', compact('items'));
    }
}
