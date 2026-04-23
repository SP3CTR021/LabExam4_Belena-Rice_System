<?php

namespace App\Http\Controllers;

use App\Models\RiceType;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('riceType')->latest()->get();
        return view('order.index', compact('orders'));
    }

    public function create()
    {
        $riceTypes = RiceType::orderBy('name')->get();
        return view('order.create', compact('riceTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'rice_type_id'  => 'required|exists:rice_types,id',
            'quantity'      => 'required|numeric|min:0.01',
        ]);

        $riceType = RiceType::findOrFail($request->rice_type_id);

        if ($riceType->stock_kg < $request->quantity) {
            return back()
                ->withInput()
                ->withErrors(['quantity' => 'Not enough stock. Available: ' . $riceType->stock_kg . ' kg.']);
        }

        $totalCost = $riceType->price_per_kilo * $request->quantity;

        Order::create([
            'customer_name'  => $request->customer_name,
            'rice_type_id'   => $riceType->id,
            'quantity'       => $request->quantity,
            'total_cost'     => $totalCost,
            'status'         => 'Pending',
            'payment_status' => 'Unpaid',
            'amount_paid'    => 0,
            'balance'        => $totalCost,
        ]);

        $riceType->stock_kg -= $request->quantity;
        $riceType->save();

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }
}
