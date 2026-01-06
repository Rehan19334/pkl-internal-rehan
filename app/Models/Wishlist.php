<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    // Menentukan nama tabel secara eksplisit
    protected $table = 'wishlists';

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    // Di sini tidak perlu ada function wishlists() atau hasInWishlist()
    // karena logika tersebut sudah dikelola oleh Model User sebagai pemilik Wishlist.
}