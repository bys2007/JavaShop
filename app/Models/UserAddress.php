<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'latitude',
        'longitude',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ──

    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

    // ── Accessors ──

    public function getFullFormattedAttribute(): string
    {
        return "{$this->address}, {$this->city}, {$this->province} {$this->postal_code}";
    }
}
