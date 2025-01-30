<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meter;
use App\Models\Payment;
use App\Models\Reading;
use App\Models\Customer;
use Carbon\Carbon;

class HomePage extends Controller
{
  public function index()
  {

    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();
    $totalPayments = Payment::sum('amount');
    $totalPaid = Payment::where('status', 'Paid')->sum('amount');
    $totalUnpaid = Payment::where('status', 'Not Paid')->sum('amount');

    $totalBills = Payment::count();
    $paidBills = Payment::where('remaining', 0.00)->count();
    $unpaidBills = Payment::where('remaining', '>', 0.00)->count();
    $totalCustomers = Customer::count();

    $activeMeters = Meter::where('status', 'Active')->count();
    $inactiveMeters = Meter::where('status', 'Damaged')->count();

    $newCustomers = Meter::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->where('status', 'Active')
                    ->count();

    $newActive = Meter::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->where('status', 'Active')
                        ->count();

    $active = Meter::where('status', 'Active')->count();
    $maintenance = Meter::where('status', 'Maintenance')->count();
    $newMaintenance = Meter::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->where('status', 'Maintenance')
                        ->count();

    $damaged = Meter::where('status', 'Damaged')->count();
    $newDamaged = Meter::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->where('status', 'Damaged')
                        ->count();

    $meterLogs = Reading::all();
    $totalConsumption = $meterLogs->reduce(function ($carry, $log) {
      return $carry + max(0, $log->value - $log->previous);
    }, 0);
    return view('content.pages.pages-home', compact(
      'newActive', 
      'totalBills', 
      'paidBills',
      'activeMeters',
      'inactiveMeters',
      'unpaidBills',
      'newCustomers',
      'totalCustomers',
      'totalUnpaid',
      'totalConsumption',
      'active',
      'maintenance',
      'damaged',
      'newMaintenance',
      'newDamaged',
      'totalPayments',
      'totalPaid'
    ));
  }
}
