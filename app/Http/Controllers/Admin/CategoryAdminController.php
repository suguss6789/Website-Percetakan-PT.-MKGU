<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryAdminController extends Controller
{
    public function index()
    {
        $categories = Category::ordered()->withCount('products')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        $category = Category::create($this->validated($request));

        return redirect()->route('admin.categories.index')->with('status', "Kategori “{$category->name}” ditambahkan.");
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validated($request, $category));

        return redirect()->route('admin.categories.index')->with('status', 'Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        $count = $category->products()->count();
        if ($count > 0) {
            return back()->with('error', "Kategori “{$category->name}” masih berisi {$count} produk. Pindahkan atau hapus produknya dulu.");
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Kategori dihapus.');
    }

    private function validated(Request $request, ?Category $category = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80', Rule::unique('categories', 'name')->ignore($category?->id)],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ], [], ['name' => 'nama kategori', 'description' => 'deskripsi']);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        if (! $category || $category->name !== $data['name']) {
            $data['slug'] = Category::uniqueSlug($data['name'], $category?->id);
        }

        return $data;
    }
}
