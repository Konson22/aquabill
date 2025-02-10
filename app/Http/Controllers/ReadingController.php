<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $readings = Payment::with(['customer', 'reading', 'meter'])->whereNull('description')->orderBy('date', 'desc')->get();

        $totalReadings = $readings->count();
        $totalConsumption = $readings->reduce(function ($carry, $log) {
            return $carry + max(0, $log->reading->value - $log->reading->previous);
        }, 0);

        $months = $this->months();

        $years = $this->years();
        
        return view('readings.index', compact(
            'readings',
            'years',
            'months',
            'totalReadings',
            'totalConsumption'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $customer = Customer::find($request->input('customer_id'));
        $lastPayment = $customer->payments->last();

        $previous_balance = 0;
        $Previouse_bill_no = 0;

        if($lastPayment){
            $previous_balance = $lastPayment->remaining ?? 0;
            $Previouse_bill_no = $lastPayment->id;
            $lastPayment->status = 'Paid'; 
            $lastPayment->save();
        }

        $charges = 0;

        // dd($Previouse_bill_no);

        if ($customer && $customer->category) {
            foreach ($customer->category->tariffs as $tariff) {
                $charges += $tariff->amount;
            }
        }

        $reading = new Reading();
        $reading->meter_id = $request->input('meter_id');
        $reading->value = $request->input('value');
        $reading->previous = $request->input('previous');
        $reading->date = $request->input('date') ?? Carbon::now();
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
        $payment->previous_balance = $previous_balance;
        $payment->Previouse_bill_no = $Previouse_bill_no;
        $payment->method = $request->input('method');
        $payment->customer_id = $request->input('customer_id');
        $payment->reading_id = $reading->id;
        $payment->paid = $request->input('paid');
        $payment->date = $request->input('date') ?? Carbon::now();
        $payment->status = $request->input('status');
        $payment->remaining = $remaining;
        $payment->updated_at = Carbon::now();
        $payment->save();

        $customer->credit += $remaining;
        $customer->save();

        return back()->with('success', 'Reading created successfully.');
    }

    private function calculateAmount($value, $previous, $tariff, $charges)
    {
        $difference = $value - $previous;
        $amount = ($difference * $tariff) + $charges;

        return $amount;
    }

    function specific_month(Request $request){
        
        $monthName = $request->input('month');
        $year = $request->input('year');

        $query = Payment::query();
        
        if ($monthName) {
            $month = Carbon::parse($monthName)->month;
            $query->whereMonth('date', $month);
        }

        if ($year) {
            $query->whereYear('date', $year);
        }

        // Get the results
        $readings = $query->with(['customer', 'reading', 'meter'])->whereNull('description')->orderBy('date', 'desc')->get();

        $totalReadings = $readings->count();
        $totalConsumption = $readings->reduce(function ($carry, $log) {
            return $carry + max(0, $log->reading->value - $log->reading->previous);
        }, 0);

        $months = $this->months();

        $years = $this->years();

        return view('readings.specific_month', compact(
            'readings',
            'years',
            'monthName',
            'months',
            'year',
            'totalReadings',
            'totalConsumption',
        ));
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
            'date' => 'nullable|date',
        ]);
    
        $reading = Reading::findOrFail($id);
        $reading->update([
            'value' => $request->input('value'),
            'previous' => $request->input('previous'),
            'date' => $request->input('date'),
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

    public function readings_api()
    {
        $readings = Reading::with(['customer', 'reading', 'meter'])->get();

        return response()->json($readings);
      
    }

    private function months(){
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        return $months;
    }
    private function years(){
        $years = [2025,2024,2023, 2022,2021,2020];

        return $years;
    }
}
