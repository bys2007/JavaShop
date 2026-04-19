<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'bank_name',
        'account_number',
        'proof_image',
        'amount',
        'midtrans_transaction_id',
        'midtrans_status',
        'status',
        'rejection_reason',
        'confirmed_at',
        'confirmed_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
    ];

    // ── Relationships ──

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    // ── Accessors ──

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }
}
