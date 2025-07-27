@extends('layouts.admin')

@section('title', 'Manajemen Order')
@section('page-title', 'Order')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-brand-teal">Daftar Order</h2>
</div>
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
@endif
<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded shadow text-sm">
        <thead>
            <tr class="bg-brand-teal text-white">
                <th class="py-2 px-4">No</th>
                <th class="py-2 px-4">Kode Order</th>
                <th class="py-2 px-4">Pelanggan</th>
                <th class="py-2 px-4">No HP</th>
                <th class="py-2 px-4">Total</th>
                <th class="py-2 px-4">Status Order</th>
                <th class="py-2 px-4">Status Pembayaran</th>
                <th class="py-2 px-4">Desain</th>
                <th class="py-2 px-4">Tanggal</th>
                <th class="py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $i => $order)
            <tr class="border-b">
                <td class="py-2 px-4">{{ $orders->firstItem() + $i }}</td>
                <td class="py-2 px-4">{{ $order->order_code }}</td>
                <td class="py-2 px-4">{{ $order->customer_name }}</td>
                <td class="py-2 px-4">{{ $order->customer_phone }}</td>
                                        <td class="py-2 px-4">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td class="py-2 px-4">
                    <span class="px-2 py-1 rounded {{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                </td>
                <td class="py-2 px-4">
                    <span class="px-2 py-1 rounded {{ $order->payment_status_color }}">
                        {{ $order->payment_status_label }}
                    </span>
                </td>
                <td class="py-2 px-4">
                    @php
                        $hasDesign = false;
                        $designCount = 0;
                        foreach($order->details as $detail) {
                            if($detail->design_file) {
                                $hasDesign = true;
                                $designCount++;
                            }
                        }
                    @endphp
                    @if($hasDesign)
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">
                                <i class="fas fa-image"></i> {{ $designCount }} Desain
                            </span>
                            <button onclick="showOrderDesigns({{ $order->id }})" 
                                    class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition">
                                <i class="fas fa-eye"></i> Lihat
                            </button>
                        </div>
                    @else
                        <span class="text-gray-400 text-xs">Tidak ada desain</span>
                    @endif
                </td>
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
    <div class="mt-4">{{ $orders->links() }}</div>
</div>

<!-- Order Designs Modal -->
<div id="orderDesignsModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg max-w-6xl max-h-full overflow-auto relative">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 id="orderDesignsTitle" class="text-lg font-semibold text-gray-800">Desain Order</h3>
            <button onclick="closeOrderDesignsModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
                &times;
            </button>
        </div>
        <div id="orderDesignsContent" class="p-4">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<script>
function showOrderDesigns(orderId) {
    // Show loading
    document.getElementById('orderDesignsContent').innerHTML = '<div class="text-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-gray-500"></i><p class="mt-2">Memuat desain...</p></div>';
    document.getElementById('orderDesignsModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Fetch order designs via AJAX
    fetch(`/admin/orders/${orderId}/designs`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('orderDesignsContent').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('orderDesignsContent').innerHTML = '<div class="text-center py-8 text-red-500">Error: ' + error.message + '</div>';
        });
}

function closeOrderDesignsModal() {
    document.getElementById('orderDesignsModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('orderDesignsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeOrderDesignsModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeOrderDesignsModal();
    }
});
</script>
@endsection 