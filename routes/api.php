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
    $customer = Customer::find(1);

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
            'name' => 'required|string',
        ]);

        $dataArray = $request['data'];

        foreach ($dataArray as $data){
            $customer = Customer::find($data['customer_id']);
            
            if($customer){
                $previous_balance = 0;
                $Previouse_bill_no = 0;
                $last_reading = 0;
    
                if($customer->lastReading){
                    $last_reading = $customer->lastReading->value;
                }
    
                if($customer->payments){
                    $lastPayment = $customer->payments->last() ?? 0;
                    $previous_balance = $lastPayment->remaining ?? 0;
                    $Previouse_bill_no = $lastPayment->id ?? 0;
                }

                if($last_reading != $data['value']){
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
                    $reading->billing_officer = $request->input('name');
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
                    $payment->previous_balance = $previous_balance;
                    $payment->Previouse_bill_no = $Previouse_bill_no;
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


