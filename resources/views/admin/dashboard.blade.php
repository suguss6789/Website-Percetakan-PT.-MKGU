@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brand-teal mb-2">{{ $totalProducts }}</div>
        <div class="text-gray-600">Produk</div>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brand-teal mb-2">{{ $totalCategories }}</div>
        <div class="text-gray-600">Kategori</div>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brand-teal mb-2">{{ $totalOrders }}</div>
        <div class="text-gray-600">Order</div>
    </div>
    <div class="bg-white rounded shadow p-6 text-center">
        <div class="text-3xl font-bold text-brand-teal mb-2">{{ $totalCustomers }}</div>
        <div class="text-gray-600">Pelanggan</div>
    </div>
</div>
<div class="bg-white rounded shadow p-6 mb-8">
    <h3 class="text-lg font-bold text-brand-teal mb-4">Order Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-brand-teal text-white">
                    <th class="py-2 px-4">No</th>
                    <th class="py-2 px-4">Kode Order</th>
                    <th class="py-2 px-4">Pelanggan</th>
                    <th class="py-2 px-4">No HP</th>
                    <th class="py-2 px-4">Total</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $i => $order)
                <tr>
                    <td class="py-2 px-4">{{ $i + 1 }}</td>
                    <td class="py-2 px-4">{{ $order->order_code }}</td>
                    <td class="py-2 px-4">{{ $order->customer_name }}</td>
                    <td class="py-2 px-4">{{ $order->customer_phone }}</td>
                                            <td class="py-2 px-4">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="py-2 px-4">
                        <span class="px-2 py-1 rounded {{ $order->status_color }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="py-2 px-4">{{ $order->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">Belum ada order.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 