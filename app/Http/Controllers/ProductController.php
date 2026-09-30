<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::ordered()->withCount(['products' => fn ($q) => $q->active()])->get();
        $activeCategory = $categories->firstWhere('slug', $request->query('kategori'));
        $search = trim((string) $request->query('q'));

        $products = Product::active()
            ->with(['category', 'sizes'])
            ->when($activeCategory, fn ($q) => $q->where('category_id', $activeCategory->id))
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")))
            ->ordered()
            ->paginate(24)
            ->withQueryString();

        return view('pages.products.index', compact('products', 'categories', 'activeCategory', 'search'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load(['category', 'sizes', 'images']);

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->with(['category', 'sizes'])
            ->ordered()
            ->take(4)
            ->get();

        return view('pages.products.show', compact('product', 'related'));
    }
}
