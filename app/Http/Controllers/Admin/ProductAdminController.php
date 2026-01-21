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
            'base_price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|max:4096',
            'size_names' => 'nullable|array',
            'size_prices' => 'nullable|array',
            'finishing_names' => 'nullable|array',
            'finishing_prices' => 'nullable|array',
            'material_names' => 'nullable|array',
            'material_prices' => 'nullable|array',
        ]);
        
        if (empty($validated['description'])) {
            $validated['description'] = null;
        }
        
        $sizes = [];
        if ($request->has('size_names') && $request->has('size_prices')) {
            $sizeNames = $request->input('size_names');
            $sizePrices = $request->input('size_prices');
            for ($i = 0; $i < count($sizeNames); $i++) {
                if (!empty($sizeNames[$i]) && !empty($sizePrices[$i])) {
                    $sizes[] = [
                        'name' => $sizeNames[$i],
                        'price' => (float) $sizePrices[$i]
                    ];
                }
            }
        }
        
        $finishings = [];
        if ($request->has('finishing_names') && $request->has('finishing_prices')) {
            $finishingNames = $request->input('finishing_names');
            $finishingPrices = $request->input('finishing_prices');
            for ($i = 0; $i < count($finishingNames); $i++) {
                if (!empty($finishingNames[$i]) && !empty($finishingPrices[$i])) {
                    $finishings[] = [
                        'name' => $finishingNames[$i],
                        'price' => (float) $finishingPrices[$i]
                    ];
                }
            }
        }
        
        $materials = [];
        if ($request->has('material_names') && $request->has('material_prices')) {
            $materialNames = $request->input('material_names');
            $materialPrices = $request->input('material_prices');
            for ($i = 0; $i < count($materialNames); $i++) {
                if (!empty($materialNames[$i]) && !empty($materialPrices[$i])) {
                    $materials[] = [
                        'name' => $materialNames[$i],
                        'price' => (float) $materialPrices[$i]
                    ];
                }
            }
        }
        
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('products', 'public');
        } else {
            unset($validated['cover_image']);
        }
        
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['sizes'] = $sizes;
        $validated['finishings'] = $finishings;
        $validated['materials'] = $materials;
        
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
            'base_price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|max:4096',
            'size_names' => 'nullable|array',
            'size_prices' => 'nullable|array',
            'finishing_names' => 'nullable|array',
            'finishing_prices' => 'nullable|array',
            'material_names' => 'nullable|array',
            'material_prices' => 'nullable|array',
        ]);
        
        if (empty($validated['description'])) {
            $validated['description'] = null;
        }
        
        $sizes = [];
        if ($request->has('size_names') && $request->has('size_prices')) {
            $sizeNames = $request->input('size_names');
            $sizePrices = $request->input('size_prices');
            for ($i = 0; $i < count($sizeNames); $i++) {
                if (!empty($sizeNames[$i]) && !empty($sizePrices[$i])) {
                    $sizes[] = [
                        'name' => $sizeNames[$i],
                        'price' => (float) $sizePrices[$i]
                    ];
                }
            }
        }
        
        $finishings = [];
        if ($request->has('finishing_names') && $request->has('finishing_prices')) {
            $finishingNames = $request->input('finishing_names');
            $finishingPrices = $request->input('finishing_prices');
            for ($i = 0; $i < count($finishingNames); $i++) {
                if (!empty($finishingNames[$i]) && !empty($finishingPrices[$i])) {
                    $finishings[] = [
                        'name' => $finishingNames[$i],
                        'price' => (float) $finishingPrices[$i]
                    ];
                }
            }
        }
        
        $materials = [];
        if ($request->has('material_names') && $request->has('material_prices')) {
            $materialNames = $request->input('material_names');
            $materialPrices = $request->input('material_prices');
            for ($i = 0; $i < count($materialNames); $i++) {
                if (!empty($materialNames[$i]) && !empty($materialPrices[$i])) {
                    $materials[] = [
                        'name' => $materialNames[$i],
                        'price' => (float) $materialPrices[$i]
                    ];
                }
            }
        }
        
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('products', 'public');
        } else {
            unset($validated['cover_image']);
        }
        
        $validated['sizes'] = $sizes;
        $validated['finishings'] = $finishings;
        $validated['materials'] = $materials;
        
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