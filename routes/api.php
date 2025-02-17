<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Models\Customer;
use App\Models\Meter;
use App\Models\MeterLog;
use App\Models\Location;
use App\Models\Reading;
use App\Models\Payment;
use App\Models\Category;
use App\Models\User;


Route::post('/auth_login', function(Request $request){
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages(['email' => 'Invalid credentials']);
    }

    return response()->json([
        'status' => true, 
        'token' => $user->createToken('authToken')->plainTextToken,
        'profile' => [
            'name' => $user->name,
            'email' => $user->email,
        ]
    ]);
});


Route::middleware(['auth:sanctum'])->group(function () {

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

                    if($customer->payments->last()){
                        $lastPayment = $customer->payments->last();
                        $previous_balance = $lastPayment->remaining;
                        $Previouse_bill_no = $lastPayment->id;
    
                        $lastPayment->status = 'Paid'; 
                        $lastPayment->save();
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
    
    Route::get('/readings_api', function(){
        $readings = Reading::all();
    
        return response()->json($readings);
    });
    
    Route::get('/customers', function () {
        $customer = Customer::find(1);
    
        $customers = Customer::whereNotNull(['meter_id'])->with([
            'location',
            'lastReading',
            'meter'
        ])->get();
        return response()->json($customers);
    });
});


