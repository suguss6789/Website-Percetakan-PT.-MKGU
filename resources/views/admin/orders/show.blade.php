<!-- @extends('layouts.admin')

@section('title', 'Detail Order')
@section('page-title', 'Detail Order')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded shadow p-8">
    <h2 class="text-xl font-bold text-brand-teal mb-6">Detail Order</h2>
    <div class="mb-4">
        <div class="font-semibold">Nama Pelanggan:</div>
        <div>{{ $order->customer_name }}</div>
    </div>
    <div class="mb-4">
        <div class="font-semibold">Tanggal Order:</div>
        <div>{{ $order->created_at->format('d M Y H:i') }}</div>
    </div>
    <div class="mb-4">
        <div class="font-semibold">Status Order:</div>
        <div><span class="px-2 py-1 rounded {{ $order->status_color }}">{{ $order->status_label }}</span></div>
    </div>
    <div class="mb-4">
        <div class="font-semibold">Status Pembayaran:</div>
        <div><span class="px-2 py-1 rounded {{ $order->payment_status_color }}">{{ $order->payment_status_label }}</span></div>
    </div>
    <div class="mb-4">
        <div class="font-semibold mb-2">Daftar Produk:</div>
        <table class="min-w-full text-sm mb-2">
            <thead>
                <tr class="bg-brand-teal text-white">
                    <th class="py-2 px-4">Produk</th>
                    <th class="py-2 px-4">Jumlah</th>
                    <th class="py-2 px-4">Harga</th>
                    <th class="py-2 px-4">Subtotal</th>
                    <th class="py-2 px-4">Desain</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->details as $detail)
                <tr>
                    <td class="py-2 px-4">{{ $detail->product->name ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $detail->quantity }}</td>
                    <td class="py-2 px-4">Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td class="py-2 px-4">Rp{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                    <td class="py-2 px-4">
                        @if($detail->design_file)
                            @if(Str::endsWith(strtolower($detail->design_file), ['.jpg', '.jpeg', '.png']))
                                <div class="flex flex-col space-y-2">
                                    <!-- Thumbnail Preview --
                                    <img src="{{ asset('storage/' . $detail->design_file) }}" 
                                         alt="Desain" 
                                         class="h-16 w-16 object-cover rounded shadow cursor-pointer hover:opacity-75 transition-opacity"
                                         onclick="openImageModal('{{ asset('storage/' . $detail->design_file) }}', '{{ basename($detail->design_file) }}')">
                                    
                                    <!-- Action Buttons --
                                    <div class="flex space-x-1">
                                        <button onclick="openImageModal('{{ asset('storage/' . $detail->design_file) }}', '{{ basename($detail->design_file) }}')"
                                                class="px-2 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition">
                                            <i class="fas fa-eye"></i> Review
                                        </button>
                                        <a href="{{ asset('storage/' . $detail->design_file) }}" 
                                           download="{{ basename($detail->design_file) }}"
                                           class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            @elseif(Str::endsWith(strtolower($detail->design_file), ['.pdf']))
                                <div class="flex flex-col space-y-2">
                                    <span class="inline-block bg-gray-100 px-2 py-1 rounded text-xs text-gray-700">
                                        <i class="fas fa-file-pdf text-red-500"></i> PDF: {{ basename($detail->design_file) }}
                                    </span>
                                    <a href="{{ asset('storage/' . $detail->design_file) }}" 
                                       download="{{ basename($detail->design_file) }}"
                                       class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition">
                                        <i class="fas fa-download"></i> Download PDF
                                    </a>
                                </div>
                            @else
                                <div class="flex flex-col space-y-2">
                                    <span class="inline-block bg-gray-100 px-2 py-1 rounded text-xs text-gray-700">
                                        <i class="fas fa-file"></i> File: {{ basename($detail->design_file) }}
                                    </span>
                                    <a href="{{ asset('storage/' . $detail->design_file) }}" 
                                       download="{{ basename($detail->design_file) }}"
                                       class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition">
                                        <i class="fas fa-download"></i> Download File
                                    </a>
                                </div>
                            @endif
                        @else
                            <span class="text-gray-400 text-xs">Tidak ada desain</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.orders.download-invoice', $order) }}" class="px-4 py-2 rounded bg-brand-teal text-white font-bold hover:bg-teal-700 transition">
            <i class="fas fa-file-download mr-2"></i>Download Invoice
        </a>
    </div>
    <div class="mb-4 text-right font-bold text-brand-teal">
                        Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}
    </div>
    
    <!-- Bukti Pembayaran Section --
    <div class="mb-6" id="payment-proof">
        <div class="font-semibold mb-3 text-lg text-brand-teal">
            <i class="fas fa-receipt mr-2"></i>Bukti Pembayaran
        </div>
        @if($order->payment_proof)
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span class="text-green-800 font-semibold">Bukti pembayaran telah diupload</span>
                    </div>
                    <span class="text-sm text-green-600">{{ $order->updated_at->format('d M Y H:i') }}</span>
                </div>
                
                <div class="flex flex-col space-y-3">
                    @php
                        $fileExtension = strtolower(pathinfo($order->payment_proof, PATHINFO_EXTENSION));
                        $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']);
                    @endphp
                    
                    @if($isImage)
                        <!-- Image Preview --
                        <div class="flex flex-col space-y-2">
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                                 alt="Bukti Pembayaran" 
                                 class="max-w-xs h-auto rounded shadow cursor-pointer hover:opacity-75 transition-opacity"
                                 onclick="openPaymentProofModal('{{ asset('storage/' . $order->payment_proof) }}', '{{ basename($order->payment_proof) }}')">
                            
                            <div class="flex space-x-2">
                                <button onclick="openPaymentProofModal('{{ asset('storage/' . $order->payment_proof) }}', '{{ basename($order->payment_proof) }}')"
                                        class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition">
                                    <i class="fas fa-eye mr-1"></i>Review Bukti Pembayaran
                                </button>
                                <a href="{{ route('admin.orders.download-payment-proof', $order) }}" 
                                   class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition">
                                    <i class="fas fa-download mr-1"></i>Download Bukti Pembayaran
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- File Preview --
                        <div class="flex flex-col space-y-2">
                            <div class="bg-gray-100 p-3 rounded border">
                                <div class="flex items-center">
                                    @if($fileExtension === 'pdf')
                                        <i class="fas fa-file-pdf text-red-500 mr-2 text-xl"></i>
                                    @else
                                        <i class="fas fa-file text-gray-500 mr-2 text-xl"></i>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ basename($order->payment_proof) }}</div>
                                        <div class="text-sm text-gray-600">{{ strtoupper($fileExtension) }} File</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" 
                                   target="_blank"
                                   class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition">
                                    <i class="fas fa-eye mr-1"></i>Review Bukti Pembayaran
                                </a>
                                <a href="{{ route('admin.orders.download-payment-proof', $order) }}" 
                                   class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition">
                                    <i class="fas fa-download mr-1"></i>Download Bukti Pembayaran
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                    <span class="text-yellow-800">Belum ada bukti pembayaran yang diupload</span>
                </div>
            </div>
        @endif
    </div>
    
    <div class="flex justify-end">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Kembali</a>
    </div>
</div>

<!-- Image Modal --
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg max-w-4xl max-h-full overflow-auto relative">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-800"></h3>
            <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
                &times;
            </button>
        </div>
        <div class="p-4">
            <img id="modalImage" src="" alt="Desain Preview" class="max-w-full h-auto">
        </div>
        <div class="flex justify-end p-4 border-t space-x-2">
            <a id="downloadLink" href="" download="" 
               class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                <i class="fas fa-download"></i> Download
            </a>
            <button onclick="closeImageModal()" 
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Payment Proof Modal --
<div id="paymentProofModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg max-w-4xl max-h-full overflow-auto relative">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 id="paymentProofModalTitle" class="text-lg font-semibold text-gray-800"></h3>
            <button onclick="closePaymentProofModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
                &times;
            </button>
        </div>
        <div class="p-4">
            <img id="paymentProofModalImage" src="" alt="Bukti Pembayaran Preview" class="max-w-full h-auto">
        </div>
        <div class="flex justify-end p-4 border-t space-x-2">
            <a href="{{ route('admin.orders.download-payment-proof', $order) }}" 
               class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                <i class="fas fa-download"></i> Download
            </a>
            <button onclick="closePaymentProofModal()" 
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc, fileName) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').textContent = 'Preview Desain: ' + fileName;
    document.getElementById('downloadLink').href = imageSrc;
    document.getElementById('downloadLink').download = fileName;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

function openPaymentProofModal(imageSrc, fileName) {
    document.getElementById('paymentProofModalImage').src = imageSrc;
    document.getElementById('paymentProofModalTitle').textContent = 'Preview Bukti Pembayaran: ' + fileName;
    document.getElementById('paymentProofModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePaymentProofModal() {
    document.getElementById('paymentProofModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('paymentProofModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentProofModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePaymentProofModal();
    }
});
</script>
@endsection  -->