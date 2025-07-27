<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order_details;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class OrderAdminController extends Controller
{
    public function index()
    {
        $orders = Order::with('details')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('details.product');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:quotation,waiting_payment,in_production,completed,cancelled',
            'payment_status' => 'required|string|in:unpaid,down_payment,paid',
        ]);
        $order->update($validated);
        return redirect()->route('admin.orders.index')->with('success', 'Status order dan pembayaran berhasil diupdate!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus!');
    }

    public function designs(Order $order)
    {
        $order->load('details.product');
        return view('admin.orders.designs', compact('order'));
    }
} 