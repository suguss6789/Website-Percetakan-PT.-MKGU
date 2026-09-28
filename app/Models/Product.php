<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'short_description', 'description',
        'specifications', 'min_order', 'production_time', 'cover_image',
        'is_featured', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (blank($product->slug)) {
                $product->slug = static::uniqueSlug($product->name, $product->id);
            }
        });

        static::deleting(function (Product $product) {
            $product->images->each->delete();
            if ($product->cover_image) {
                Storage::disk('public')->delete([$product->cover_image, thumb_path($product->cover_image)]);
            }
        });
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(ProductSize::class)->orderBy('sort_order')->orderBy('id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('updated_at');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->cover_image ? Storage::disk('public')->url($this->cover_image) : null;
    }

    public function getThumbUrlAttribute(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }
        $thumb = thumb_path($this->cover_image);

        return Storage::disk('public')->exists($thumb)
            ? Storage::disk('public')->url($thumb)
            : $this->image_url;
    }

    /**
     * Kisaran harga keseluruhan untuk kartu produk.
     * Satuan sama di semua ukuran → "Rp800 – Rp5.000 / lembar".
     * Satuan berbeda → "Mulai Rp800".
     * Tanpa ukuran → null (tampilan: "Harga sesuai permintaan").
     */
    public function getPriceRangeLabelAttribute(): ?string
    {
        $sizes = $this->relationLoaded('sizes') ? $this->sizes : $this->sizes()->get();
        if ($sizes->isEmpty()) {
            return null;
        }

        $min = $sizes->min('price_min');
        $max = $sizes->map(fn ($s) => $s->price_max ?? $s->price_min)->max();
        $units = $sizes->pluck('unit')->unique();
        $hasOpenEnd = $sizes->contains(fn ($s) => $s->price_max === null);

        if ($units->count() > 1) {
            return 'Mulai ' . rupiah($min);
        }

        $unit = ' / ' . Str::after($units->first(), 'per ');
        if ($min === $max || ($hasOpenEnd && $sizes->count() === 1)) {
            return 'Mulai ' . rupiah($min) . $unit;
        }

        return rupiah($min) . ' – ' . rupiah($max) . $unit;
    }

    public function getWhatsappUrlAttribute(): string
    {
        return wa_link("Halo MKGU, saya ingin tanya harga *{$this->name}*.\nJumlah: \nBahan: \n\n(dari website: " . route('products.show', $this) . ')');
    }
}
