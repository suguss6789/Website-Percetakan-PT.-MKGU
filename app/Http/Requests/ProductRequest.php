<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Buang baris ukuran/spesifikasi yang dibiarkan kosong.
        $sizes = collect($this->input('sizes', []))
            ->filter(fn ($s) => filled($s['label'] ?? null) || filled($s['price_min'] ?? null))
            ->map(fn ($s) => [
                ...$s,
                'price_min' => $this->toInt($s['price_min'] ?? null),
                'price_max' => $this->toInt($s['price_max'] ?? null),
            ])
            ->values()->all();

        $specs = collect($this->input('specs', []))
            ->filter(fn ($s) => filled($s['label'] ?? null) || filled($s['value'] ?? null))
            ->values()->all();

        $this->merge([
            'sizes' => $sizes,
            'specs' => $specs,
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    private function toInt($value): ?int
    {
        $digits = preg_replace('/\D/', '', (string) $value);

        return $digits === '' ? null : (int) $digits;
    }

    public function rules(): array
    {
        $product = $this->route('product');
        $image = ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

        return [
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:140', 'alpha_dash', Rule::unique('products', 'slug')->ignore($product?->id)],
            'category_id' => ['required', 'exists:categories,id'],
            'short_description' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:10000'],
            'min_order' => ['nullable', 'string', 'max:60'],
            'production_time' => ['nullable', 'string', 'max:60'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],

            'cover_image' => [$product?->cover_image ? 'nullable' : 'required', ...$image],
            'gallery' => ['nullable', 'array', 'max:8'],
            'gallery.*' => $image,
            'image_order' => ['nullable', 'array'],
            'image_order.*' => ['nullable', 'integer', 'min:0', 'max:99'],

            'sizes' => ['array', 'max:20'],
            'sizes.*.label' => ['required', 'string', 'max:60'],
            'sizes.*.dimension' => ['nullable', 'string', 'max:60'],
            'sizes.*.price_min' => ['required', 'integer', 'min:0', 'max:1000000000'],
            'sizes.*.price_max' => ['nullable', 'integer', 'gte:sizes.*.price_min', 'max:1000000000'],
            'sizes.*.unit' => ['required', 'string', 'max:30'],
            'sizes.*.note' => ['nullable', 'string', 'max:150'],

            'specs' => ['array', 'max:20'],
            'specs.*.label' => ['required', 'string', 'max:40'],
            'specs.*.value' => ['required', 'string', 'max:300'],
        ];
    }

    public function after(): array
    {
        return [function ($validator) {
            $product = $this->route('product');
            $existing = $product ? $product->images()->count() : 0;
            if ($existing + count($this->file('gallery', [])) > 8) {
                $validator->errors()->add('gallery', "Galeri maksimal 8 foto. Saat ini sudah ada {$existing} foto.");
            }
        }];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama produk', 'category_id' => 'kategori', 'short_description' => 'deskripsi singkat',
            'description' => 'deskripsi lengkap', 'cover_image' => 'gambar utama', 'gallery.*' => 'foto galeri',
            'sizes.*.label' => 'nama ukuran', 'sizes.*.price_min' => 'harga minimum', 'sizes.*.price_max' => 'harga maksimum',
            'sizes.*.unit' => 'satuan', 'specs.*.label' => 'label spesifikasi', 'specs.*.value' => 'isi spesifikasi',
        ];
    }

    public function messages(): array
    {
        return [
            'sizes.*.price_max.gte' => 'Harga maksimum harus sama atau lebih besar dari harga minimum.',
            'cover_image.required' => 'Gambar utama wajib diunggah.',
            '*.max' => ':Attribute terlalu panjang/besar.',
        ];
    }
}
