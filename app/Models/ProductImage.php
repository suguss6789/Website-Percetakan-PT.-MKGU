<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = ['path', 'alt', 'sort_order'];

    protected static function booted(): void
    {
        static::deleting(function (ProductImage $image) {
            Storage::disk('public')->delete([$image->path, thumb_path($image->path)]);
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }

    public function getThumbUrlAttribute(): string
    {
        $thumb = thumb_path($this->path);

        return Storage::disk('public')->exists($thumb) ? Storage::disk('public')->url($thumb) : $this->url;
    }
}
