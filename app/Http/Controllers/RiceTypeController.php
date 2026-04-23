<?php

namespace App\Http\Controllers;

use App\Models\RiceType;
use Illuminate\Http\Request;

class RiceTypeController extends Controller
{
    public function index()
    {
        $riceTypes = RiceType::orderBy('name')->get();

        return view('rice.index', compact('riceTypes'));
    }

    public function create()
    {
        return view('rice.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rice_types',
            'description' => 'nullable|string',
            'stock_kg' => 'required|numeric|min:0',
            'price_per_kilo' => 'required|numeric|min:0',
        ]);

        RiceType::create($request->only(['name', 'description', 'stock_kg', 'price_per_kilo']));

        return redirect()->route('menus.index')->with('success', 'Rice type added successfully.');
    }

    public function edit(RiceType $riceType)
    {
        return view('rice.edit', compact('riceType'));
    }

    public function update(Request $request, RiceType $riceType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rice_types,name,' . $riceType->id,
            'description' => 'nullable|string',
            'stock_kg' => 'required|numeric|min:0',
            'price_per_kilo' => 'required|numeric|min:0',
        ]);

        $riceType->update($request->only(['name', 'description', 'stock_kg', 'price_per_kilo']));

        return redirect()->route('menus.index')->with('success', 'Rice type updated successfully.');
    }

    public function destroy(RiceType $riceType)
    {
        $riceType->delete();

        return redirect()->route('menus.index')->with('success', 'Rice type deleted successfully.');
    }

    public function addStock(RiceType $riceType)
    {
        return view('rice.add-stock', compact('riceType'));
    }

    public function storeStock(Request $request, RiceType $riceType)
    {
        $request->validate([
            'quantity_kg' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);

        $riceType->stock_kg += $request->quantity_kg;
        $riceType->save();

        return redirect()->route('menus.index')->with('success', 'Stock added successfully.');
    }
}
