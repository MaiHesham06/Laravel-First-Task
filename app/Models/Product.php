<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $fillable = ['category_id', 'brand_id' , 'name', 'description', 'price'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }
    
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('type')->orderBy('value');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(ProductRating::class)->latest();
    }

    public function averageRating(): float
    {
        return round($this->ratings->avg('rating') ?? 0, 1);
    }

    public function userRating(): ?ProductRating
    {
        if (! Auth::check()) {
            return null;
        }

        return $this->ratings->firstWhere('user_id', Auth::user()->id);
    }
}
