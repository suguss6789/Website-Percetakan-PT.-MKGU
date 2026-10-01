<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    protected $fillable = ['name', 'description', 'logo', 'url', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::deleting(function (Partner $partner) {
            if ($partner->logo) {
                Storage::disk('public')->delete([$partner->logo, thumb_path($partner->logo)]);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::disk('public')->url($this->logo) : null;
    }
}
