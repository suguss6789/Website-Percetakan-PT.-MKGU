<!-- @extends('layouts.admin')

@section('title', 'Edit Status Order')
@section('page-title', 'Edit Status Order')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded shadow p-8">
    <h2 class="text-xl font-bold text-brand-teal mb-6">Edit Status Order</h2>
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-6">
            <label class="block mb-1 font-semibold" for="status">Status Order</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" required>
                <option value="quotation" {{ old('status', $order->status) == 'quotation' ? 'selected' : '' }}>Penawaran</option>
                <option value="waiting_payment" {{ old('status', $order->status) == 'waiting_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="in_production" {{ old('status', $order->status) == 'in_production' ? 'selected' : '' }}>Diproses</option>
                <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-semibold" for="payment_status">Status Pembayaran</label>
            <select name="payment_status" id="payment_status" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" required>
                <option value="unpaid" {{ old('payment_status', $order->payment_status) == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                <option value="down_payment" {{ old('payment_status', $order->payment_status) == 'down_payment' ? 'selected' : '' }}>DP Dibayar</option>
                <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('admin.orders.index') }}" class="mr-4 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-6 py-2 rounded bg-brand-teal text-white font-bold hover:bg-teal-700 transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection  -->