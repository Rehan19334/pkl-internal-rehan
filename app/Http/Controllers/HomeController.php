<?php
// ================================================
// FILE: app/Http/Controllers/HomeController.php
// FUNGSI: Menangani halaman utama website
// ================================================

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda.
     *
     * Halaman ini menampilkan:
     * - Hero section (static)
     * - Kategori populer
     * - Produk unggulan (featured)
     * - Produk terbaru
     */
    public function index()
    {
        // ================================================
        // AMBIL DATA KATEGORI
        // - Hanya yang aktif
        // - Hitung jumlah produk di masing-masing kategori
        // ================================================
        $categories = Category::query()
            ->active() // Scope: hanya is_active = true
            ->withCount(['activeProducts' => function ($q) {
                $q->where('is_active', true)
                    ->where('stock', '>', 0);
            }])
            ->having('active_products_count', '>', 0) // Hanya yang punya produk
            ->orderBy('name')
            ->take(8) // Batasi 8 kategori
            ->get();

        // ================================================
        // PRODUK UNGGULAN (FEATURED)
        // - Flag is_featured = true
        // - Aktif dan ada stok
        // ================================================
        $featuredProducts = Product::query()
            ->select('id', 'name', 'slug', 'price', 'discount_price', 'category_id', 'is_featured') // Select only needed columns
            ->with(['category:id,name,slug', 'primaryImage:id,image_path,product_id']) // Eager load with specific columns
            ->active()                           // Scope: is_active = true
            ->inStock()                          // Scope: stock > 0
            ->featured()                         // Scope: is_featured = true
            ->latest()
            ->take(8)
            ->get();

        // ================================================
        // PRODUK TERBARU
        // - Urutkan dari yang paling baru
        // ================================================
        $latestProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->active()
            ->inStock()
            ->latest() // Order by created_at DESC
            ->take(8)
            ->get();

        // ================================================
        // KIRIM DATA KE VIEW
        // compact() membuat array ['key' => $key]
        // ================================================
        return view('home', compact(
            'categories',
            'featuredProducts',
            'latestProducts'
        ));
    }
}