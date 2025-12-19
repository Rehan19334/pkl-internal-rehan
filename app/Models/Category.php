<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ==================== BOOT METHOD ====================

    /**
     * Method boot() dipanggil saat model di-initialize.
     * Kita gunakan untuk auto-generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        // Event "creating" dipanggil sebelum model disimpan (baru)
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $slug = Str::slug($category->name);

                // Pastikan slug unik
                $count = static::where('slug', 'like', "{$slug}%")->count();
                $category->slug = $count ? "{$slug}-" . ($count + 1) : $slug;
            }
        });

        // Event "updating" dipanggil sebelum model diupdate
        static::updating(function ($category) {
            // Jika nama berubah, update slug juga
            if ($category->isDirty('name')) {
                $slug = Str::slug($category->name);
                $count = static::where('slug', 'like', "{$slug}%")
                    ->where('id', '!=', $category->id)
                    ->count();

                $category->slug = $count ? "{$slug}-" . ($count + 1) : $slug;
            }
        });
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Kategori memiliki banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Produk aktif dalam kategori.
     * NOTE:
     * - Jangan tambahkan filter berat di sini
     * - Filter stok & status sebaiknya di Controller
     */
    public function activeProducts()
    {
        return $this->hasMany(Product::class)
                    ->where('is_active', true);
    }

    // ==================== SCOPES ====================

    /**
     * Scope untuk filter kategori aktif.
     * Penggunaan: Category::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ==================== ACCESSORS ====================

    /**
     * Hitung jumlah produk aktif dalam kategori.
     * NOTE:
     * - Gunakan withCount() di Controller untuk performa
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->count();
    }

    /**
     * URL gambar kategori atau placeholder.
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/category-placeholder.png');
    }
}
