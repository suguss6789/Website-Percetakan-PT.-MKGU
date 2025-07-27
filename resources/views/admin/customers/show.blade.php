@extends('layouts.admin')

@section('title', 'Detail Pelanggan')
@section('page-title', 'Detail Pelanggan')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded shadow p-8 mb-8">
    <h2 class="text-xl font-bold text-brand-teal mb-6">Detail Pelanggan</h2>
    <div class="mb-4">
        <div class="font-semibold">Nama:</div>
        <div>{{ $customer->customer_name }}</div>
    </div>
    <div class="mb-4">
        <div class="font-semibold">Email:</div>
        <div>{{ $customer->customer_email }}</div>
    </div>
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.customers.edit', $customer->customer_email) }}" class="mr-2 px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600">Edit</a>
        <form action="{{ route('admin.customers.destroy', $customer->customer_email) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pelanggan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">Hapus</button>
        </form>
    </div>
</div>
<div class="max-w-2xl mx-auto bg-white rounded shadow p-8">
    <h3 class="text-lg font-bold text-brand-teal mb-4">Daftar Order Pelanggan</h3>
    <table class="min-w-full bg-white rounded shadow text-sm">
        <thead>
            <tr class="bg-brand-teal text-white">
                <th class="py-2 px-4">Kode Order</th>
                <th class="py-2 px-4">Status</th>
                <th class="py-2 px-4">Total</th>
                <th class="py-2 px-4">Tanggal</th>
                <th class="py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-b">
                <td class="py-2 px-4">{{ $order->order_code }}</td>
                <td class="py-2 px-4">
                    <span class="px-2 py-1 rounded {{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                </td>
                                        <td class="py-2 px-4">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td class="py-2 px-4">{{ $order->created_at->format('d M Y') }}</td>
                <td class="py-2 px-4">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-brand-teal hover:underline mr-2">Detail</a>
                    <a href="{{ route('admin.orders.edit', $order) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus order ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 