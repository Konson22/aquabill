<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Neighborhood;
use App\Models\Customer;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'number' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'neighborhood_id' => 'nullable|string',
            'new_neighborhood' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($request->neighborhood_id === 'new') {
            $neighborhood = Neighborhood::create(['name' => $request->new_neighborhood]);
            $neighborhoodId = $neighborhood->id;
        } else {
            $neighborhoodId = $request->neighborhood_id;
        }

        $location = Location::create([
            'customer_id' => $request->customer_id,
            'number' => $request->number,
            'name' => $request->name ?? '',
            'address' => $request->address,
            'neighborhood_id' => $neighborhoodId,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        $customer->location_id = $location->id;
        $customer->save();

        return back()->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $location = Location::findOrFail($id);
        return view('locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'number' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'neighborhood_id' => 'nullable|string',
        'new_neighborhood' => 'nullable|string|max:255',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    if ($request->neighborhood_id === 'new') {
        $neighborhood = Neighborhood::create(['name' => $request->new_neighborhood]);
        $neighborhoodId = $neighborhood->id;
    } else {
        $neighborhoodId = $request->neighborhood_id;
    }

    $location = Location::findOrFail($id);
    $location->update([
        'customer_id' => $request->customer_id,
        'number' => $request->number,
        'name' => $request->name,
        'address' => $request->address,
        'neighborhood_id' => $neighborhoodId,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude
    ]);

    $customer = Customer::findOrFail($request->customer_id);
    $customer->location_id = $location->id;
    $customer->save();

    return back()->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Location deleted successfully.');
    }
}