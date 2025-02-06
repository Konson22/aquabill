<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reading;
use App\Models\Payment;
use App\Models\Customer;

class ReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $readings = Reading::all();
        return view('readings.index', compact('readings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $customer = Customer::find($request->input('customer_id'));
        $charges = 0;

        if ($customer && $customer->category) {
            foreach ($customer->category->tariffs as $tariff) {
                $charges += $tariff->amount;
            }
        }

        $reading = new Reading();
        $reading->meter_id = $request->input('meter_id');
        $reading->value = $request->input('value');
        $reading->previous = $request->input('previous');
        $reading->date = $request->input('date');
        $reading->source = $request->input('source');
        $reading->billing_officer = $request->input('billing_officer');
        $reading->save();

        $amount = $this->calculateAmount(
            $request->input('value'),
            $request->input('previous'),
            $request->input('tariff'),
            $charges
        );

        $paid = $request->input('paid');
        $remaining = $amount - $paid;

        $payment = new Payment();
        $payment->tariff = $request->input('tariff');
        $payment->amount = $amount;
        $payment->charges = $charges;
        $payment->method = $request->input('method');
        $payment->customer_id = $request->input('customer_id');
        $payment->reading_id = $reading->id;
        $payment->paid = $request->input('paid');
        $payment->date = $request->input('date');
        $payment->status = $request->input('status');
        $payment->remaining = $remaining + $charges;
        $payment->updated_at = null;
        $payment->save();

        $customer->credit += $remaining + $charges;
        $customer->save();

        return back()->with('success', 'Reading created successfully.');
    }

    private function calculateAmount($value, $previous, $tariff, $charges)
    {
        $difference = $value - $previous;
        $amount = ($difference * $tariff) + $charges;

    return $amount;
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'value' => 'required|numeric',
            'previous' => 'required|numeric',
        ]);
    
        $reading = Reading::findOrFail($id);
        $reading->update([
            'value' => $request->input('value'),
            'previous' => $request->input('previous'),
        ]);


        return back()->with('success', 'Reading updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete the reading
        $reading->delete();

        return redirect()->route('readings.index')
            ->with('success', 'Reading deleted successfully.');
    }
}
