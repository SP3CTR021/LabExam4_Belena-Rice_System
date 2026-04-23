<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\RiceType;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('name')->get();
        $riceTypes = RiceType::orderBy('name')->get();

        return view('menu.index', compact('menus', 'riceTypes'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price_per_kilo' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Menu::create($request->only(['name', 'category', 'price_per_kilo', 'stock']));

        return redirect()->route('menus.index')->with('success', 'Rice product added successfully.');
    }

    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price_per_kilo' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $menu->update($request->only(['name', 'category', 'price_per_kilo', 'stock']));

        return redirect()->route('menus.index')->with('success', 'Rice product updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Rice product deleted successfully.');
    }
}
