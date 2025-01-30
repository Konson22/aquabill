<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Bill;

class BillingReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bills = Bill::when($search, function ($query, $search) {
                return $query->where('customer_name', 'like', "%{$search}%")
                             ->orWhere('phone', 'like', "%{$search}%")
                             ->orWhere('contract_number', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('reports.billing.index', compact('bills', 'search'));
    }

    public function create()
    {
        // Logic for creating a new report
    }

    public function store(Request $request)
    {
        // Logic for storing a new report
    }
}
