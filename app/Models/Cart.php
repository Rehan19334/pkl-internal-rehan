<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
    ];

    // Otomatis load items beserta product
    protected $with = ['items.product'];

    // ==================== RELATIONSHIPS ====================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Hitung subtotal semua item di keranjang
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            // pastikan total_price tidak null
            return $item->total_price ?? ($item->product->price * $item->quantity);
        });
    }

    /**
     * Hitung total berat semua item di keranjang
     */
    public function getTotalWeightAttribute()
    {
        return $this->items->sum(function ($item) {
            // pastikan total_weight tidak null
            return $item->total_weight ?? ($item->product->weight * $item->quantity);
        });
    }
}