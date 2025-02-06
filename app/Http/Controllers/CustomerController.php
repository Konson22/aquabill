<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Neighborhood;
use App\Models\Category;
use App\Models\Meter;
use App\Models\Type;
use App\Models\Reading;
use App\Models\Payment;
use App\Models\MeterLog;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('phone', $search)
            ->orWhere('contract', 'like', "%$search%")
            ->orWhere('first_name', 'like', "%$search%")
            ->orWhere('last_name', 'like', "%$search%");
        }

        $customers = $query->paginate(10);

        $totalCustomers = Customer::count();
        // $customers = Customer::paginate(5);
        $categories = Category::all();
        $inactivecustomers = Meter::where('status', 'Maintenance')->orWhere('status', 'Damaged')->count();
        return view('customers.index', compact('customers', 'categories', 'totalCustomers','inactivecustomers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        $categories = Category::all();
        $meters = Meter::all();
        return view('customers.create', compact('locations', 'categories', 'meters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|regex:/^0*[1-9]\d*$/',
            'email' => 'nullable|string|email|max:255',
            'location_id' => 'nullable|exists:locations,id',
            'category_id' => 'nullable|exists:categories,id',
            'meter_id' => 'nullable|exists:meters,id',
            'date' => 'nullable|date',
            'contract' => 'nullable|regex:/^0*[1-9]\d*$/',
            'credit' => 'nullable|integer',
        ]);

        $customer = Customer::create($request->all());

        return redirect()->route('customers.show', $customer->id)
        ->with('success', 'Customer account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $customer = Customer::findOrFail($id);
        $categories = Category::all();

        $location = $customer->location_id ? Location::findOrFail($customer->location_id) : null;

        $neighborhoods = Neighborhood::all();
        $types = Type::all();
        $meter = Type::find($customer->meter_id);

        // dd($customer->meter->type);

        $payments = Payment::where('customer_id', $id)->whereNull('description')->orderBy('created_at', 'desc')->paginate(12);

        $paymentsonetime = Payment::where('customer_id', $id)
                ->whereNotNull('description')
                ->orderBy('created_at', 'desc')
                ->paginate(12);

        $meterId = $customer->meter_id;

        $readings = Reading::where('meter_id', $meterId)
        ->orderBy('created_at', 'desc')
        ->paginate(12);

        $current = Reading::where('meter_id', $meterId)->orderBy('created_at', 'desc')->value('value');
        $today = date('m-d-Y');

        $latestReading = Reading::where('meter_id', $meterId)->orderBy('created_at', 'desc')->first();

        $usage = $latestReading ? $latestReading->value - $latestReading->previous : 0;

        $meterLogs = MeterLog::with(['oldMeter', 'newMeter'])
        ->where('customer_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

      

        return view('customers.show', compact(
            'customer', 
            'categories', 
            'types',
            'meter',
            'readings',
            'current',
            'today',
            'usage',
            'payments',
            'neighborhoods',
            'location',
            'meterLogs',
            'paymentsonetime'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $locations = Location::all();
        $categories = Category::all();
        $meters = Meter::all();
        $meter = Meter::find($id);
        return view('customers.edit', compact('customer', 'locations', 'categories', 'meters','meter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|integer',
            'email' => 'nullable|string|email|max:255',
            'location_id' => 'nullable|exists:locations,id',
            'category_id' => 'nullable|exists:categories,id',
            'meter_id' => 'nullable|exists:meters,id',
            'date' => 'nullable|date',
            'contract' => 'nullable|integer',
        ]);

        // Find the customer
        $customer = Customer::findOrFail($id);

        // Update the customer
        $customer->update($request->all());

        return back()->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function download($id)
    {
        $payment = Payment::with(['customer.location', 'reading.meter.type'])->find($id);

        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found.');
        }

        $consumption = 0;

    if ($payment->reading) {
        $consumption = $payment->reading->value - $payment->reading->previous;
    }

        $customerName = $payment->customer->last_name;
        $paymentDate = Carbon::parse($payment->date)->format('Y-m-d');


        $pdf = PDF::loadView('pdf', compact('payment','consumption'));
        $pdfName = 'Invoice[' . $paymentDate . ']_Customer[' . $customerName . '].pdf';

        return $pdf->stream($pdfName);
    }

    public function downloadonetime($id)
    {
        $payment = Payment::with(['customer.location'])->find($id);

        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found.');
        }

        $consumption = 0;

        $customerName = $payment->customer->last_name;
        $paymentDate = Carbon::parse($payment->date)->format('Y-m-d');


        $pdf = PDF::loadView('pdfonetime', compact('payment','consumption'));
        $pdfName = 'Invoice[' . $paymentDate . ']_Customer[' . $customerName . '].pdf';

        return $pdf->stream($pdfName);
    }

}
