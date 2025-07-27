<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman daftar semua produk.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(12);
        return view('pages.products.products', compact('products'));
    }

    /**
     * Menampilkan halaman detail satu produk.
     */
    public function show(Product $product)
    {
        // Anda bisa menambahkan logika untuk halaman detail di sini
        return view('pages.products.show', compact('product'));
    }

    /**
     * Menangani data yang dikirim dari form di halaman detail produk.
     * (METHOD BARU YANG DITAMBAHKAN)
     */
    public function handleFormSubmission(Request $request, Product $product)
    {
        if (!$product || !$product->id) {
            abort(400, 'Produk tidak ditemukan atau binding produk gagal. Pastikan slug produk valid dan route sudah benar.');
        }
        
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'design_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Simpan ke tabel orders
        $order = Order::create([
            'order_code'      => 'ORD-' . strtoupper(Str::random(8)),
            'customer_name'   => $validated['name'],
            'customer_email'  => $validated['email'],
            'customer_phone'  => $validated['whatsapp'],
            'status'          => 'quotation',
            'total_amount'    => $product->price * $validated['quantity'],
            'payment_status'  => 'unpaid',
            'notes'           => $validated['notes'] ?? null,
        ]);

        // Proses upload file desain jika ada
        $designFilePath = null;
        if ($request->hasFile('design_file')) {
            $designFilePath = $request->file('design_file')->store('designs', 'public');
        }

        // Simpan ke tabel order_details
        OrderDetail::create([
            'order_id'      => $order->id,
            'product_id'    => $product->id,
            'quantity'      => $validated['quantity'],
            'price'         => $product->price,
            'specifications'=> $validated['notes'] ?? null,
            'design_file'   => $designFilePath,
        ]);

        // Redirect ke halaman invoice
        return redirect()->route('invoice.show', $order->order_code);
    }

    public function invoice($order_code)
    {
        $order = \App\Models\Order::where('order_code', $order_code)->with('details')->firstOrFail();
        return view('pages.invoice', compact('order'));
    }

    public function confirmPayment(Request $request, $order_code)
    {
        $order = \App\Models\Order::where('order_code', $order_code)->firstOrFail();
        $validated = $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        $order->payment_proof = $paymentProofPath;
        $order->save();
        return redirect()->route('invoice.show', $order->order_code)->with('payment_success', true);
    }

    public function downloadInvoice($order_code)
    {
        $order = \App\Models\Order::where('order_code', $order_code)->with('details.product')->firstOrFail();
        
        // Return the invoice view directly
        return view('pdf.invoice', compact('order'));
    }
}
