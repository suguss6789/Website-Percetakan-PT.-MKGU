<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductAttribute;
use App\Models\Category; // <-- Pastikan ini ada

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'cover_image',
        'is_featured',
        'price',
        'sizes',
        'base_price',
        'finishings',
        'materials',
    ];

    protected $casts = [
        'sizes' => 'array',
        'finishings' => 'array',
        'materials' => 'array',
    ];

    /**
     * Mendapatkan kategori dari produk ini.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Accessor untuk mendapatkan URL gambar yang benar.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->cover_image) {
            return null;
        }

        if (str_starts_with($this->cover_image, 'assets/')) {
            return asset($this->cover_image);
        }

        return asset('storage/' . $this->cover_image);
    }
}