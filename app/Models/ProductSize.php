<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSize extends Model
{
    protected $fillable = ['label', 'dimension', 'price_min', 'price_max', 'unit', 'note', 'sort_order'];

    protected $casts = [
        'price_min' => 'integer',
        'price_max' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceLabelAttribute(): string
    {
        if ($this->price_max === null || $this->price_max === $this->price_min) {
            return 'Mulai ' . rupiah($this->price_min);
        }

        return rupiah($this->price_min) . ' – ' . rupiah($this->price_max);
    }
}
