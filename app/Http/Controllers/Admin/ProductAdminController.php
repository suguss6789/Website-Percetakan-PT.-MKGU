<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductAdminController extends Controller
{
    public function __construct(private ImageService $images)
    {
    }

    public function index(Request $request)
    {
        $categories = Category::ordered()->get();
        $search = trim((string) $request->query('q'));

        $products = Product::with(['category', 'sizes'])
            ->when($request->query('kategori'), fn ($q, $id) => $q->where('category_id', $id))
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($request->query('status') === 'aktif', fn ($q) => $q->where('is_active', true))
            ->when($request->query('status') === 'nonaktif', fn ($q) => $q->where('is_active', false))
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'categories', 'search'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product(['is_active' => true]),
            'categories' => Category::ordered()->get(),
        ]);
    }

    public function store(ProductRequest $request)
    {
        $product = DB::transaction(function () use ($request) {
            $product = Product::create($this->payload($request));
            $this->syncRelations($product, $request);

            return $product;
        });

        return redirect()->route('admin.products.edit', $product)->with('status', "Produk “{$product->name}” berhasil ditambahkan.");
    }

    public function edit(Product $product)
    {
        $product->load(['sizes', 'images']);

        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::ordered()->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            $product->update($this->payload($request, $product));
            $this->syncRelations($product, $request);
        });

        return redirect()->route('admin.products.edit', $product)->with('status', 'Perubahan tersimpan.');
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', "Produk “{$name}” dihapus.");
    }

    public function toggle(Product $product)
    {
        $product->update(['is_active' => ! $product->is_active]);

        return back()->with('status', $product->is_active
            ? "“{$product->name}” sekarang tampil di website."
            : "“{$product->name}” disembunyikan dari website.");
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        abort_unless($image->product_id === $product->id, 404);
        $image->delete();

        return back()->with('status', 'Foto dihapus dari galeri.');
    }

    private function payload(ProductRequest $request, ?Product $product = null): array
    {
        $data = $request->safe()->only([
            'name', 'category_id', 'short_description', 'description',
            'min_order', 'production_time', 'is_featured', 'is_active',
        ]);
        $data['sort_order'] = (int) $request->input('sort_order', 0);
        $data['slug'] = $request->filled('slug')
            ? $request->input('slug')
            : Product::uniqueSlug($data['name'], $product?->id);
        $data['specifications'] = collect($request->validated('specs', []))
            ->map(fn ($s) => ['label' => trim($s['label']), 'value' => trim($s['value'])])
            ->values()->all();

        if ($request->hasFile('cover_image')) {
            $this->images->delete($product?->cover_image);
            $data['cover_image'] = $this->images->store($request->file('cover_image'));
        }

        return $data;
    }

    private function syncRelations(Product $product, ProductRequest $request): void
    {
        // Ukuran: ganti seluruhnya sesuai urutan di form.
        $product->sizes()->delete();
        foreach ($request->validated('sizes', []) as $i => $size) {
            $product->sizes()->create([
                'label' => $size['label'],
                'dimension' => $size['dimension'] ?? null,
                'price_min' => $size['price_min'],
                'price_max' => $size['price_max'] ?? null,
                'unit' => $size['unit'],
                'note' => $size['note'] ?? null,
                'sort_order' => $i,
            ]);
        }

        // Urutan foto galeri yang sudah ada.
        foreach ((array) $request->input('image_order', []) as $id => $order) {
            $product->images()->whereKey($id)->update(['sort_order' => (int) $order]);
        }

        // Foto galeri baru.
        $next = (int) $product->images()->max('sort_order') + 1;
        foreach ($request->file('gallery', []) as $file) {
            $product->images()->create([
                'path' => $this->images->store($file),
                'alt' => $product->name,
                'sort_order' => $next++,
            ]);
        }
    }
}
