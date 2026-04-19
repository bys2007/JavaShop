<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderShippedNotification;
use App\Notifications\OrderDeliveredNotification;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'voucher_id',
        'order_number',
        'payment_method',
        'status',
        'subtotal',
        'shipping_cost',
        'discount',
        'total',
        'courier',
        'courier_service',
        'tracking_number',
        'snap_token',
        'notes',
    ];

    protected $casts = [
        'status' => 'string',
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // ── Boot ──

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Order $order) {
            if (empty($order->order_number)) {
                $order->order_number = static::generateOrderNumber();
            }
        });

        static::updated(function (Order $order) {
            if ($order->isDirty('status')) {
                if ($order->status === 'shipped') {
                    Notification::route('mail', $order->user->email)->notify(new OrderShippedNotification($order));
                } elseif ($order->status === 'delivered') {
                    Notification::route('mail', $order->user->email)->notify(new OrderDeliveredNotification($order));
                }
            }
        });
    }

    /**
     * Generate a unique order number: JVS-YYYYMMDD-XXXX
     */
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'JVS-' . date('Ymd') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (static::where('order_number', $number)->exists());

        return $number;
    }

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ── Scopes ──

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopePendingPayment(Builder $query): Builder
    {
        return $query->where('status', 'pending_payment');
    }

    // ── Accessors ──

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_admin' => 'Menunggu Konfirmasi',
            'pending_payment' => 'Menunggu Pembayaran',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending_admin' => 'warning',
            'pending_payment' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'error',
            default => 'tertiary',
        };
    }

    public function getCanBeReviewedAttribute(): bool
    {
        return $this->status === 'delivered';
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        if (!$this->payment) {
            return 'Belum dibayar';
        }

        return match ($this->payment->status) {
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'rejected' => 'Ditolak',
            default => ucfirst($this->payment->status),
        };
    }
}
