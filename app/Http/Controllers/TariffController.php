<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tariff;
use App\Models\Category;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tariffs = Tariff::all();
        $totalTariffs = Tariff::count();
        $categories = Category::all();
        $totalCategories = Category::count();
        return view('tariffs.index', compact('tariffs','categories','totalCategories','totalTariffs'));
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
         $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        $tariff = new Tariff();
        $tariff->name = $request->name;
        $tariff->amount = $request->amount;
        $tariff->date = $request->date;
        $tariff->category_id = $request->category_id;
        $tariff->save();

        return back()->with('success', 'Tariff created successfully.');
    }

    /**
     * Display the specified resource.
     */
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
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:50',
            'tariff' => 'required|numeric|between:0,100',
        ]);

        // Find the category
        $category = Category::findOrFail($id);

        // Update the category
        $category->update([
            'name' => $request->name,
            'tariff' => $request->tariff,
        ]);

        return view('categories.index');
        // return back()->with('success', 'Reading updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tariff = Tariff::findOrFail($id);
        $tariff->delete();

        return back()->with('success', 'Tariff deleted successfully.');
    }
}
