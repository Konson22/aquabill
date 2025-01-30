<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alert; // Assuming you have an Alert model
use App\Models\Customer; // Assuming you have a Customer model

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alerts = Alert::with('customer')->get(); // Assuming you have a relationship defined in the Alert model
        return view('alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all(); // Fetch all customers to populate dropdown
        return view('alerts.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|string|max:50',
            'message' => 'required|string',
            'date' => 'nullable|date',
        ]);

        // Create a new alert
        Alert::create([
            'customer_id' => $request->customer_id,
            'type' => $request->type,
            'message' => $request->message,
            'date' => $request->date,
        ]);

        return redirect()->route('alerts.index')->with('success', 'Alert created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $alert = Alert::findOrFail($id);
        return view('alerts.show', compact('alert'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $alert = Alert::findOrFail($id);
        $customers = Customer::all(); // Fetch all customers to populate dropdown
        return view('alerts.edit', compact('alert', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|string|max:50',
            'message' => 'required|string',
            'date' => 'nullable|date',
        ]);

        // Find the alert
        $alert = Alert::findOrFail($id);

        // Update the alert
        $alert->update([
            'customer_id' => $request->customer_id,
            'type' => $request->type,
            'message' => $request->message,
            'date' => $request->date,
        ]);

        return redirect()->route('alerts.index')->with('success', 'Alert updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alert = Alert::findOrFail($id);
        $alert->delete();
        return redirect()->route('alerts.index')->with('success', 'Alert deleted successfully.');
    }
}