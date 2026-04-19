<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    // ── Relationships ──

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistProducts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wishlists');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable_id')
            ->where('notifiable_type', static::class)
            ->orderBy('created_at', 'desc');
    }

    // ── Helpers ──

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return $this->avatar;
        }

        $initials = collect(explode(' ', $this->name))
            ->map(fn($word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->take(2)
            ->join('');

        return "https://ui-avatars.com/api/?name={$initials}&background=B8924A&color=FAF7F2&size=80&font-size=0.4&bold=true";
    }

    public function getCartCountAttribute(): int
    {
        return $this->cartItems()->sum('quantity');
    }
}
