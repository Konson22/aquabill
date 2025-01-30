<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Models\Customer;
use App\Models\Meter;
use App\Models\MeterLog;
use App\Models\Location;
use App\Models\Reading;
use App\Models\Payment;
use App\Models\Category;

Route::get('/customers', function () {
    $customers = Customer::whereNotNull(['meter_id'])->with([
        'location',
        'lastReading',
        'meter'
    ])->get();
    return response()->json($customers);
});


Route::post('/readings', function (Request $request) {
    try {
        $request->validate([
            'data' => 'required|array',
        ]);
    
        $dataArray = $request->input('data');

        foreach ($dataArray as $data){
            $customer = Customer::find($data['customer_id']);

            if($customer){
                $charges = 0;
                foreach ($customer->category->tariffs as $tariff) {
                    $charges += $tariff->amount;
                }
    
                $reading = new Reading();
                $reading->meter_id = $data['meter_id'];
                $reading->value = $data['value'];
                $reading->previous = $data['previous'];
                $reading->date = Carbon::now();
                $reading->source = 'mobile app';
                $reading->save();
    
                $difference = $data['value'] - $data['previous'];
                $amount = ($difference * $customer->category->tariff) + $charges;
              
                $paid = 0;
                $remaining = $amount - $paid;
        
                $payment = new Payment();
                $payment->tariff = $customer->category->tariff;
                $payment->amount = $amount;
                $payment->charges = $charges;
                $payment->method = 'Cash';
                $payment->customer_id = $data['customer_id'];
                $payment->reading_id = $reading->id;
                $payment->paid = 0;
                $payment->date = Carbon::now();
                $payment->status = 'Not Paid';
                $payment->remaining = $remaining + $charges;
                $payment->updated_at = null;
                $payment->save();
        
                $customer->credit += $remaining + $charges;
                $customer->save();
            }
        }
    
        return response()->json(['status' => true]);

    } catch (\Throwable $th) {
        throw $th;
    }
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/login', function () {
        return response()->json(['message' => 'Welcome to the API Dashboard']);
    });
});
