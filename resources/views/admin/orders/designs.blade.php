<!-- <div class="space-y-6">
    <div class="border-b pb-4">
        <h4 class="text-lg font-semibold text-gray-800">Order: {{ $order->order_code }}</h4>
        <p class="text-sm text-gray-600">Pelanggan: {{ $order->customer_name }}</p>
    </div>

    @php
        $designs = $order->details->filter(function($detail) {
            return $detail->design_file;
        });
    @endphp

    @if($designs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($designs as $detail)
                <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4">
                        <h5 class="font-semibold text-gray-800 mb-2">{{ $detail->product->name ?? 'Produk' }}</h5>
                        <p class="text-sm text-gray-600 mb-3">Jumlah: {{ $detail->quantity }}</p>
                        
                        @if(Str::endsWith(strtolower($detail->design_file), ['.jpg', '.jpeg', '.png']))
                            <!-- Image Design --
                            <div class="space-y-3">
                                <img src="{{ asset('storage/' . $detail->design_file) }}" 
                                     alt="Desain {{ $detail->product->name ?? 'Produk' }}" 
                                     class="w-full h-48 object-cover rounded border cursor-pointer hover:opacity-90 transition-opacity"
                                     onclick="openImageModal('{{ asset('storage/' . $detail->design_file) }}', '{{ basename($detail->design_file) }}')">
                                
                                <div class="flex space-x-2">
                                    <button onclick="openImageModal('{{ asset('storage/' . $detail->design_file) }}', '{{ basename($detail->design_file) }}')"
                                            class="flex-1 px-3 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition">
                                        <i class="fas fa-eye mr-1"></i> Review
                                    </button>
                                    <a href="{{ asset('storage/' . $detail->design_file) }}" 
                                       download="{{ basename($detail->design_file) }}"
                                       class="flex-1 px-3 py-2 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition text-center">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                </div>
                            </div>
                        @elseif(Str::endsWith(strtolower($detail->design_file), ['.pdf']))
                            <!-- PDF Design --
                            <div class="space-y-3">
                                <div class="bg-gray-100 p-4 rounded border text-center">
                                    <i class="fas fa-file-pdf text-red-500 text-4xl mb-2"></i>
                                    <p class="text-sm text-gray-700">{{ basename($detail->design_file) }}</p>
                                </div>
                                
                                <a href="{{ asset('storage/' . $detail->design_file) }}" 
                                   download="{{ basename($detail->design_file) }}"
                                   class="w-full px-3 py-2 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition text-center block">
                                    <i class="fas fa-download mr-1"></i> Download PDF
                                </a>
                            </div>
                        @else
                            <!-- Other File Types --
                            <div class="space-y-3">
                                <div class="bg-gray-100 p-4 rounded border text-center">
                                    <i class="fas fa-file text-gray-500 text-4xl mb-2"></i>
                                    <p class="text-sm text-gray-700">{{ basename($detail->design_file) }}</p>
                                </div>
                                
                                <a href="{{ asset('storage/' . $detail->design_file) }}" 
                                   download="{{ basename($detail->design_file) }}"
                                   class="w-full px-3 py-2 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition text-center block">
                                    <i class="fas fa-download mr-1"></i> Download File
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <i class="fas fa-image text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-500">Tidak ada desain untuk order ini</p>
        </div>
    @endif
</div>

<!-- Image Modal for Designs --
<div id="designImageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg max-w-4xl max-h-full overflow-auto relative">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 id="designModalTitle" class="text-lg font-semibold text-gray-800"></h3>
            <button onclick="closeDesignImageModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
                &times;
            </button>
        </div>
        <div class="p-4">
            <img id="designModalImage" src="" alt="Desain Preview" class="max-w-full h-auto">
        </div>
        <div class="flex justify-end p-4 border-t space-x-2">
            <a id="designDownloadLink" href="" download="" 
               class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                <i class="fas fa-download"></i> Download
            </a>
            <button onclick="closeDesignImageModal()" 
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc, fileName) {
    document.getElementById('designModalImage').src = imageSrc;
    document.getElementById('designModalTitle').textContent = 'Preview Desain: ' + fileName;
    document.getElementById('designDownloadLink').href = imageSrc;
    document.getElementById('designDownloadLink').download = fileName;
    document.getElementById('designImageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDesignImageModal() {
    document.getElementById('designImageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('designImageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDesignImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDesignImageModal();
    }
});
</script>  -->