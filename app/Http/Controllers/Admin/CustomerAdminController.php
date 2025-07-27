<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CustomerAdminController extends Controller
{
    public function index()
    {
        // Ambil pelanggan unik berdasarkan email
        $customers = Order::select('customer_name', 'customer_email')
            ->groupBy('customer_email', 'customer_name')
            ->orderByDesc(DB::raw('MAX(created_at)'))
            ->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function show($email)
    {
        // Ambil semua order dari pelanggan ini
        $orders = Order::where('customer_email', $email)->orderByDesc('created_at')->get();
        $customer = $orders->first();
        return view('admin.customers.show', compact('customer', 'orders'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
        ]);
        // Buat order dummy untuk menyimpan pelanggan baru (atau bisa buat tabel khusus pelanggan jika ingin lebih baik)
        Order::create([
            'order_code' => 'DUMMY-' . uniqid(),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => '',
            'status' => 'quotation',
            'total_amount' => 0,
            'payment_status' => 'unpaid',
            'notes' => 'Pelanggan ditambah manual dari admin panel',
        ]);
        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function edit($email)
    {
        $customer = Order::where('customer_email', $email)->orderByDesc('created_at')->first();
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $email)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
        ]);
        // Update semua order dengan email lama ke data baru
        Order::where('customer_email', $email)
            ->update([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
            ]);
        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil diupdate!');
    }

    public function destroy($email)
    {
        // Hapus semua order dengan email pelanggan ini
        Order::where('customer_email', $email)->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan dan semua order terkait berhasil dihapus!');
    }
} 