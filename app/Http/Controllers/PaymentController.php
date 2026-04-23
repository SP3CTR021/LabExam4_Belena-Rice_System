<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.riceType')->latest()->get();

        return view('payments.index', compact('payments'));
    }

    public function create(Order $order)
    {
        return view('payments.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $amount = $request->input('amount');
        $newAmountPaid = $order->amount_paid + $amount;
        $change = 0;

        if ($newAmountPaid > $order->total_cost) {
            $change = $newAmountPaid - $order->total_cost;
            $newAmountPaid = $order->total_cost;
        }

        $balanceAfter = max($order->total_cost - $newAmountPaid, 0);
        $paymentStatus = $newAmountPaid >= $order->total_cost ? 'Paid' : 'Partial';
        $orderStatus = $paymentStatus === 'Paid' ? 'Completed' : 'Processing';

        $order->update([
            'amount_paid' => $newAmountPaid,
            'balance' => $balanceAfter,
            'payment_status' => $paymentStatus,
            'status' => $orderStatus,
        ]);

        Payment::create([
            'order_id' => $order->id,
            'amount' => $amount,
            'change' => $change,
            'balance_after' => $balanceAfter,
            'status' => $paymentStatus,
        ]);

        return redirect()->route('orders.index')->with('success', 'Payment processed successfully.');
    }
}
