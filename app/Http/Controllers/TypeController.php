<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type; // Assuming you have a Type model

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();
        return view('types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'size' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'manufactory' => 'required|string|max:50',
            'date' => 'nullable|date',
        ]);

        // Create a new type
        Type::create($request->all());

        return redirect()->route('meters.index')->with('success', 'Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $type = Type::findOrFail($id);
        return view('types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $type = Type::findOrFail($id);
        return view('types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'manufactory' => 'required|string|max:50',
            'date' => 'nullable|date',
        ]);

        // Find the type
        $type = Type::findOrFail($id);

        // Update the type
        $type->update($request->all());

        return redirect()->route('types.index')->with('success', 'Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();
        return redirect()->route('types.index')->with('success', 'Type deleted successfully.');
    }
}