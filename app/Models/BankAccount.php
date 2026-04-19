<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BankAccount extends Model
{
    protected $fillable = [
        'bank_name',
        'account_number',
        'account_name',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Scopes ──

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
