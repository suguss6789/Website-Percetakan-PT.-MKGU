<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'cover_image' => 'nullable|image|max:2048',
        ]);
        
        // Handle description field - convert empty string to null
        if (empty($validated['description'])) {
            $validated['description'] = null;
        }
        
        // Handle cover_image field
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('products', 'public');
        } else {
            $validated['cover_image'] = null;
        }
        
        // Set default value for is_featured if not provided
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        
        try {
            Product::create($validated);
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menambahkan produk: ' . $e->getMessage()]);
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'cover_image' => 'nullable|image|max:2048',
        ]);
        
        // Handle description field - convert empty string to null
        if (empty($validated['description'])) {
            $validated['description'] = null;
        }
        
        // Handle cover_image field
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('products', 'public');
        } else {
            $validated['cover_image'] = null;
        }
        
        try {
            $product->update($validated);
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal mengupdate produk: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
} 