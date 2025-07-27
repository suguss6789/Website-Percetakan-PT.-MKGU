@extends('layouts.app')

@section('title', 'Invoice Pemesanan')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-2xl mx-auto bg-white rounded shadow p-8">
        <h2 class="text-2xl font-bold text-brand-teal mb-4">Invoice Pemesanan</h2>
        <div class="mb-4">
            <div><span class="font-semibold">Kode Order:</span> {{ $order->order_code }}</div>
            <div><span class="font-semibold">Nama:</span> {{ $order->customer_name }}</div>
            <div><span class="font-semibold">Email:</span> {{ $order->customer_email }}</div>
            <div><span class="font-semibold">No WhatsApp:</span> {{ $order->customer_phone }}</div>
            <div><span class="font-semibold">Tanggal:</span> {{ $order->created_at->format('d M Y H:i') }}</div>
            <div><span class="font-semibold">Status Order:</span> 
                <span class="px-2 py-1 rounded {{ $order->status_color }}">
                    {{ $order->status_label }}
                </span>
            </div>
            <div><span class="font-semibold">Status Pembayaran:</span> 
                <span class="px-2 py-1 rounded {{ $order->payment_status_color }}">
                    {{ $order->payment_status_label }}
                </span>
            </div>
        </div>
        <div class="mb-6">
            <table class="min-w-full text-sm mb-2">
                <thead>
                    <tr class="bg-brand-teal text-white">
                        <th class="py-2 px-4">Produk</th>
                        <th class="py-2 px-4">Jumlah</th>
                        <th class="py-2 px-4">Harga</th>
                        <th class="py-2 px-4">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->details as $detail)
                    <tr>
                        <td class="py-2 px-4">{{ $detail->product->name ?? '-' }}</td>
                        <td class="py-2 px-4">{{ $detail->quantity }}</td>
                        <td class="py-2 px-4">Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="py-2 px-4">Rp{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-right font-bold text-brand-teal mt-2">
                Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}
            </div>
        </div>
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('invoice.download', $order->order_code) }}" target="_blank" class="px-4 py-2 bg-brand-teal text-white rounded hover:bg-teal-700">
                <i class="fas fa-download mr-2"></i>Download Invoice
            </a>
        </div>
        
        <hr class="my-6">
        
        <!-- Informasi Rekening -->
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-lg font-bold text-blue-800 mb-3">
                <i class="fas fa-university mr-2"></i>Informasi Rekening Pembayaran
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-3 rounded border">
                    <div class="font-semibold text-gray-800">Bank BCA</div>
                    <div class="text-lg font-mono text-gray-900">1234567890</div>
                    <div class="text-sm text-gray-600">a.n. PT. MKU</div>
                </div>
                <div class="bg-white p-3 rounded border">
                    <div class="font-semibold text-gray-800">Bank Mandiri</div>
                    <div class="text-lg font-mono text-gray-900">0987654321</div>
                    <div class="text-sm text-gray-600">a.n. PT. MKU</div>
                </div>
            </div>
            <div class="mt-3 text-sm text-blue-700">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Catatan:</strong> Mohon transfer sesuai dengan total yang tertera di atas. 
                Setelah melakukan pembayaran, silakan upload bukti transfer di bawah ini.
            </div>
        </div>
        
        <h3 class="text-lg font-bold mb-2">Konfirmasi Pembayaran</h3>
        @if($order->payment_proof)
            <div class="mb-4">
                <span class="text-green-600 font-semibold">Bukti pembayaran sudah diupload.</span>
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-blue-600 underline">Lihat Bukti Pembayaran</a>
                </div>
            </div>
        @else
            <form action="{{ route('invoice.confirm', $order->order_code) }}" method="POST" enctype="multipart/form-data" id="paymentProofForm">
                @csrf
                <div class="mb-4">
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Pembayaran (PDF/JPG/PNG, max 2MB)</label>
                    <input type="file" id="payment_proof" name="payment_proof" accept=".pdf,.jpg,.jpeg,.png" required class="w-full border rounded px-3 py-2">
                </div>
                <button type="submit" class="bg-brand-teal text-white px-6 py-2 rounded hover:bg-teal-700">Kirim Konfirmasi</button>
            </form>
        @endif
    </div>
</div>
@if(session('payment_success'))
<script>
    window.onload = function() {
        alert('Terimakasih sudah memesan.. Admin kami akan mengonfirmasi pesanan anda melalui email atau WhatsApp');
    }
</script>
@endif
@endsection 