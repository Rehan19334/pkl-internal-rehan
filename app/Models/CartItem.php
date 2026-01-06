<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ==================== ACCESSORS ====================
    public function getTotalPriceAttribute()
    {
        // fallback ke price jika discount_price null
        $price = $this->product->discount_price ?? $this->product->price ?? 0;
        return $price * $this->quantity;
    }

    public function getTotalWeightAttribute()
    {
        // fallback ke 0 jika weight null
        $weight = $this->product->weight ?? 0;
        return $weight * $this->quantity;
    }

    // ==================== BOOT ====================
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cartItem) {
            if (! $cartItem->relationLoaded('product')) {
                $cartItem->load('product');
            }
            if (! $cartItem->product) {
                throw new \Exception('Produk tidak ditemukan.');
            }
            if ($cartItem->quantity > $cartItem->product->stock) {
                throw new \Exception('Stok produk tidak mencukupi.');
            }
        });

        static::updating(function ($cartItem) {
            if (! $cartItem->relationLoaded('product')) {
                $cartItem->load('product');
            }
            if (! $cartItem->product) {
                throw new \Exception('Produk tidak ditemukan.');
            }
            if ($cartItem->quantity > $cartItem->product->stock) {
                throw new \Exception('Stok produk tidak mencukupi.');
            }
        });
    }

    /**
     * Agar $item->subtotal di view tidak 0, fallback ke total_price
     */
    public function getSubtotalAttribute()
    {
        return $this->total_price;
    }
}