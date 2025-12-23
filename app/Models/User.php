<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'google_id',
        'phone',
        'address',
    ];

    // Kolom yang disembunyikan saat serialize
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting atribut
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // User bisa punya banyak item di cart
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    // Relasi User ke Product melalui tabel wishlists
    public function wishlists()
    {
        return $this->belongsToMany(Product::class, 'wishlists')
                    ->withTimestamps();
    }

    // Relasi User ke Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ROLE HELPERS
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /*
    |--------------------------------------------------------------------------
    | WISHLIST HELPER
    |--------------------------------------------------------------------------
    */

    // Cek apakah user sudah wishlist produk tertentu
    public function hasInWishlist(Product $product): bool
    {
        return $this->wishlists()->where('product_id', $product->id)->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | AVATAR ACCESSORS
    |--------------------------------------------------------------------------
    */

    // URL avatar user
    public function getAvatarUrlAttribute(): string
    {
        // Avatar lokal
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        // Avatar dari Google
        if ($this->avatar && str_starts_with($this->avatar, 'http')) {
            return $this->avatar;
        }

        // Fallback Gravatar
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    // Inisial nama user (fallback avatar teks)
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', trim($this->name));
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return substr($initials, 0, 2);
    }
}
