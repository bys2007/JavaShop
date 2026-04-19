<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Boot ──

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // ── Relationships ──

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    // ── Scopes ──

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // ── Accessors ──

    public function getPrimaryImageAttribute(): ?string
    {
        $primary = $this->images->firstWhere('is_primary', true);
        if ($primary) {
            return $primary->image_url;
        }

        $first = $this->images->first();
        return $first?->image_url;
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        return $this->primary_image ?? "https://placehold.co/600x600/F0E8D8/6B4C35?text=" . urlencode($this->name);
    }

    public function getMinPriceAttribute(): float
    {
        return (float) $this->variants->min('price');
    }

    public function getMaxPriceAttribute(): float
    {
        return (float) $this->variants->max('price');
    }

    public function getFormattedPriceAttribute(): string
    {
        $min = $this->min_price;
        return 'Rp ' . number_format($min, 0, ',', '.');
    }

    public function getAverageRatingAttribute(): float
    {
        return (float) $this->reviews()->approved()->avg('rating') ?: 0;
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->approved()->count();
    }

    public function getTotalStockAttribute(): int
    {
        return (int) $this->variants->sum('stock');
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->total_stock > 0;
    }

    public function isInStock(): bool
    {
        return $this->is_in_stock;
    }
}
