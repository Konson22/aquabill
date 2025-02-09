<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Tariff;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Reading;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::all();
        $tariffs = Tariff::all();
        $totalTariffs = Tariff::count();
        $categories = Category::all();
        $totalCategories = Category::count();
        $totalCustomers = Customer::count();
        return view('payments.index', compact('payments','tariffs','categories','totalCategories','totalTariffs','totalCustomers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tariffs = Tariff::all();
        $customers = Customer::all();
        $readings = Reading::all();
        return view('payments.create', compact('tariffs', 'customers', 'readings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'tariff' => 'required|numeric',
            'amount' => 'required|numeric',
            'charges' => 'required|numeric',
            'method' => 'required|string|max:255',
            'customer_id' => 'required|exists:customers,id',
            'paid' => 'required|numeric',
            'reading_id' => 'nullable|exists:readings,id',
            'updated_at' => 'nullable|date',
            'status' => 'required|string|max:255',
            'remaining' => 'required|numeric',
            'description' => 'nullable|string|max:255',
        ]);

        Payment::create($request->all());

        return back()->with('success', 'Payment created successfully.');
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $tariffs = Tariff::all();
        $customers = Customer::all();
        $readings = Reading::all();
        return view('payments.edit', compact('payment', 'tariffs', 'customers', 'readings'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'paid' => 'required|numeric',
            'amount' => 'nullable|numeric',
            'charges' => 'required|numeric',
            'method' => 'required|string',
            'tariff' => 'required|numeric',
            'date' => 'nullable|date',
            'status' => 'nullable|string|max:255',
            'remaining' => 'nullable|numeric',
            'reading_id' => 'nullable|exists:readings,id',
            'description' => 'nullable|string|max:255',
        ]);
        $status = $request->input('status', 'Not Paid');
        $request->merge(['status' => $status]);

        $payment = Payment::findOrFail($id);
       

        $remaining = $payment->remaining - $request->paid;
        $paid = $payment->paid + $request->paid;

        $payment->update([
        'tariff' => $request->tariff,
        'charges' => $request->charges,
        'method' => $request->method,
        'customer_id' => $request->customer_id,
        'paid' => $paid,
        'date' => $request->date,
        'status' => $request->status,
        'remaining' => $remaining,
        'reading_id' => $request->reading_id,
        'description' => $request->description,
    ]);

        $customer = Customer::findOrFail($request->customer_id);
        $customer->credit -= $request->paid;
        $customer->save();

        return back()->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }

    /**
     * Store one-time invoice in storage.
     */
    public function storeOneTimeInvoice(Request $request)
    {

        $request->validate([
            // 'tariff' => 'required|numeric',
            'amount' => 'required|numeric',
            'charges' => 'required|numeric',
            'method' => 'required|string|max:255',
            'customer_id' => 'required|exists:customers,id',
            'paid' => 'required|numeric',
            // 'reading_id' => 'nullable|exists:readings,id',
            'date' => 'nullable|date',
            'status' => 'required|string|max:255',
            'remaining' => 'required|numeric',
            'description' => 'nullable|string|max:255',
        ]);


        $payment = new Payment();
        $payment->tariff = 0;
        $payment->amount = $request->amount;
        $payment->charges = $request->charges;
        $payment->method = $request->method;
        $payment->customer_id = $request->customer_id;
        $payment->paid = $request->paid;
        $payment->reading_id = null;
        $payment->date = $request->date ?? now();
        $payment->previous_balance = $request->previous_balance ?? 0;
        $payment->status = $request->status;
        $payment->remaining = $request->remaining;
        $payment->description = $request->description;
        $payment->save();

        return back()->with('success', 'One-time invoice created successfully.');
    }
}