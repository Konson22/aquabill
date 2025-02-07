<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Neighborhood;
use App\Models\Category;
use App\Models\Meter;
use App\Models\Type;
use App\Models\Reading;
use App\Models\Payment;
use App\Models\MeterLog;
use App\Models\Tariff;

class InvoicesController extends Controller
{
   
    
    function index(Request $request){
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $years = [2021,2023,2024, 2025];
        $invoices = Payment::with('customer')->whereNull('description')->get();
        $totalInvoices = $invoices->count();
	
        return view('invoices.index', compact('invoices', 'months', 'totalInvoices', 'years' ));
    }

    function specific_month(Request $request){

        $monthName = Carbon::parse($request->input('month'));
        $year = $request->input('year');

        $query = Payment::query();

        if ($year) {
            $query->whereYear('date', $year);
        }

        if ($monthName) {
            $month = Carbon::parse($monthName)->month;
            $query->whereMonth('date', $month);
        }

        // Get the results
        $invoices = $query->get();
        
        $totalInvoices = $invoices->count();

        // dd($invoices);
        $years = ['2021','2023','2024', '2025'];
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        return view('invoices.specific_month', compact('invoices', 'years', 'months', 'totalInvoices' ));
    }
    
    public function summary($id){
        $customer = Customer::findOrFail($id);
        $categories = Category::find($customer->category_id);
        $meter = Meter::find($customer->meter_id);
        $location = $customer->location_id ? Location::findOrFail($customer->location_id) : null;
        $neighborhoods = Neighborhood::all();
        $types = Type::all();

        $payments = Payment::with(['customer', 'reading'])->where('customer_id', $id)->whereNull('description')->orderBy('created_at', 'desc')->paginate(12);

       
        $meterId = $customer->meter_id;

        $readings = Reading::where('meter_id', $meterId)
        ->orderBy('created_at', 'desc')
        ->paginate(12);

        $current = Reading::where('meter_id', $meterId)->orderBy('created_at', 'desc')->value('value');
        $today = date('Y-m-d');

        $latestReading = Reading::where('meter_id', $meterId)->orderBy('created_at', 'desc')->first();

        $usage = $latestReading ? $latestReading->value - $latestReading->previous : 0;

        $meterLogs = MeterLog::with(['oldMeter', 'newMeter'])
        ->where('customer_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

        $fixedServiceCharge = 0;
        $tariff = Tariff::find($customer->category_id);
        if ($tariff) {
            $fixedServiceCharge = $tariff->amount;
        }
        // dd($payments);

        return view('invoices.summary', compact(
            'customer', 
            'meter', 
            'categories', 
            'types',
            'readings',
            'current',
            'today',
            'usage',
            'payments',
            'neighborhoods',
            'location',
            'meterLogs',
            'fixedServiceCharge'
        ));
    }
   

    public function print($id)
    {

        $payment = Payment::with(['customer.location', 'customer.category'])->find($id);

        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found.');
        }
        
        $category = Category::find($payment->customer->category_id);
       
        $reading = Reading::find($payment->reading_id);
        $consumption = $reading->value - $reading->previous;
        $location = Location::find($payment->customer->location_id);

        $fixedServiceCharge = 0;
        $tariff = Tariff::find($payment->customer->category_id);
        if ($tariff) {
            $fixedServiceCharge = $tariff->amount;
        }

        $customerName = $payment->customer->last_name;
        $paymentDate = Carbon::parse($payment->date)->format('d-m-Y');

        // dd($paymentDate);

        return view('invoices.print', compact(
            'payment', 
            'consumption', 
            'fixedServiceCharge', 
            'location', 
            'category', 
            'customerName',
            'reading',
            'paymentDate'
        ));
    }

    function printMultiple(){
        
        // Query payments table
        $query = Payment::query()->with(['customer.location', 'customer.category', 'customer.meters', 'reading']);

        // Paginate the result
        $payments = $query->paginate(10);
        $totalInvoices = Payment::count();


        dd($payments);
        return view('invoices.print_multiple_invoices',  compact(
            'payments', 
            'totalInvoices', 
            // 'consumption', 
        ));
    }
    function multiple(Request $request){
        $selectedIds = $request->input('selected_ids');
        $ids = json_decode($selectedIds, true);
        $payments = Payment::whereIn('id', $ids)
        ->with(['customer.location', 'customer.category', 'customer.meters', 'reading', 'tariff'])
        ->get();

        $totalInvoices = Payment::count();

        return view('invoices.multiple_invoices', compact(
            'payments', 
            'totalInvoices', 
        ));
    }

    
    public function oneTimeInvoice($id)
    {
        $payment = Payment::with(['customer.location', 'reading'])->find($id);

        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found.');
        }

        $consumption = 0;
        $category = Category::find($payment->customer->category_id);

        $customer = $payment->customer;
        $location = $payment->customer->location;
        $paymentDate = Carbon::parse($payment->date)->format('Y-m-d');

        // dd($payment);

        return view('invoices.one-time-invoice', compact('payment', 'customer', 'location', 'category'));
    }

    function months(){
        return  $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
    }
}
