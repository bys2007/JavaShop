<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'quota',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'quota' => 'integer',
        'used_count' => 'integer',
    ];

    // ── Relationships ──

    public function usages(): HasMany
    {
        return $this->hasMany(VoucherUsage::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // ── Methods ──

    /**
     * Calculate the discount amount for a given subtotal.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === 'percentage') {
            $discount = $subtotal * ($this->value / 100);
            if ($this->max_discount !== null) {
                $discount = min($discount, (float) $this->max_discount);
            }
        } else {
            // fixed
            $discount = (float) $this->value;
        }

        return min($discount, $subtotal);
    }

    /**
     * Check if the voucher is valid for a given subtotal.
     *
     * @return array{valid: bool, message: string}
     */
    public function isValid(float $subtotal = 0): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Voucher tidak aktif.'];
        }

        $today = now()->startOfDay();

        if ($this->start_date !== null && $today->lt($this->start_date)) {
            return ['valid' => false, 'message' => 'Voucher belum berlaku.'];
        }

        if ($this->end_date !== null && $today->gt($this->end_date)) {
            return ['valid' => false, 'message' => 'Voucher sudah kedaluwarsa.'];
        }

        if ($this->quota !== null && $this->used_count >= $this->quota) {
            return ['valid' => false, 'message' => 'Kuota voucher sudah habis.'];
        }

        if ($subtotal > 0 && $subtotal < (float) $this->min_purchase) {
            return [
                'valid' => false,
                'message' => 'Minimum belanja Rp ' . number_format($this->min_purchase, 0, ',', '.') . '.',
            ];
        }

        return ['valid' => true, 'message' => 'Voucher berlaku.'];
    }
}
