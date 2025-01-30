<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meter;
use App\Models\Type;
use App\Models\Customer;
use App\Models\MeterLog;
use App\Models\Reading;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MeterController extends Controller
{

    public function index()
    {
        $customers = Customer::with('meters')->get();

        $meters = Meter::whereNotIn('id', Customer::pluck('meter_id')->toArray())->get();

        $totalMeters = Meter::count();
        $inactiveMeters = Meter::where('status', 'Maintenance')->orWhere('status', 'Damaged')->count();
        $types = Type::all();
        $totalTypes = Type::count();
        $consumption = Reading::whereIn('id', function ($query) {
                                $query->select(DB::raw('MAX(id)'))
                                      ->from('readings')
                                      ->groupBy('meter_id');
                            })->sum('value');
        return view('meters.index', compact('customers','meters','types','totalTypes', 'totalMeters', 'inactiveMeters','consumption'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        return view('meters.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
    $validatedData = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'serial' => 'required|string|max:50',
        'status' => 'required|string|max:50',
        'type_id' => 'nullable|exists:types,id',
    ]);

    // Create a new meter record
    $meter = Meter::create([
        'customer_id' => $validatedData['customer_id'],
        'serial' => $validatedData['serial'],
        'status' => $validatedData['status'],
        'type_id' => $validatedData['type_id'],
    ]);

    // Update the customer record with the newly created meter ID
    $customer = Customer::findOrFail($validatedData['customer_id']);
    $oldMeterId = $customer->meter_id;
    $customer->meter_id = $meter->id;
    $customer->save();

    MeterLog::create([
            'customer_id' => $customer->id,
            'old_meter_id' => $oldMeterId,
            'new_meter_id' => $meter->id,
            'changed_at' => Carbon::now(),
        ]);

    // Redirect back with success message
    return back()->with('success', 'Meter created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $meter = Meter::findOrFail($id);
        return view('meters.show', compact('meter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::with('meters')->findOrFail($id);
        $types = Type::all();
        return view('meters.edit', compact('customer', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'serial' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'type_id' => 'nullable|exists:types,id',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $meter = Meter::findOrFail($id);
        $oldCustomer = Customer::where('meter_id', $meter->id)->first();
        $oldCustomerId = $oldCustomer ? $oldCustomer->id : null;
        $meter->update($request->all());

        // If customer_id is provided in the request and it's different from the old customer id
    if ($request->has('customer_id') && $request->customer_id != $oldCustomerId) {
        // Log the change in the MeterLog
        MeterLog::create([
            'customer_id' => $request->customer_id,
            'old_meter_id' => $meter->id, // Log the meter id as the old meter id
            'new_meter_id' => $meter->id,
            'changed_at' => now(), // Using now() helper function
        ]);

        // Update the old customer to remove the meter assignment if old customer exists
        if ($oldCustomer) {
            $oldCustomer->meter_id = null;
            $oldCustomer->save();
        }

        // Update the new customer with the new meter id
        $newCustomer = Customer::findOrFail($request->customer_id);
        $newCustomer->meter_id = $meter->id;
        $newCustomer->save();
    }

        return back()->with('success', 'Meter updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $meter = Meter::findOrFail($id);
        $meter->delete();
        return redirect()->route('meters.index')->with('success', 'Meter deleted successfully.');
    }
}