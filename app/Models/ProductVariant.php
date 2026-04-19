<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'size',
        'grind_type',
        'price',
        'stock',
        'sku',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // ── Relationships ──

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'variant_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'variant_id');
    }

    // ── Accessors ──

    public function getIsAvailableAttribute(): bool
    {
        return $this->stock > 0;
    }

    public function getDisplayNameAttribute(): string
    {
        return "{$this->size} · {$this->grind_type}";
    }

    public function getLabelAttribute(): string
    {
        return $this->display_name;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
