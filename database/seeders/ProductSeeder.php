<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil kategori yang ada
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('Tidak ada kategori ditemukan. Jalankan CategorySeeder terlebih dahulu.');
            return;
        }

        $products = [
            [
                'category_id' => $categories->first()->id,
                'name' => 'Snack Kentang Original',
                'slug' => 'snack-kentang-original',
                'description' => 'Snack kentang renyah dengan rasa original yang lezat. Cocok untuk camilan sehari-hari.',
                'price' => 15000,
                'discount_price' => null,
                'stock' => 100,
                'weight' => 100,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories->first()->id,
                'name' => 'Snack Kentang Pedas',
                'slug' => 'snack-kentang-pedas',
                'description' => 'Snack kentang dengan level kepedasan yang pas. Cocok untuk pecinta makanan pedas.',
                'price' => 17000,
                'discount_price' => 15000,
                'stock' => 80,
                'weight' => 100,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories->first()->id,
                'name' => 'Keripik Singkong Balado',
                'slug' => 'keripik-singkong-balado',
                'description' => 'Keripik singkong dengan bumbu balado khas yang gurih dan pedas.',
                'price' => 20000,
                'discount_price' => null,
                'stock' => 60,
                'weight' => 150,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $categories->first()->id,
                'name' => 'Keripik Pisang Coklat',
                'slug' => 'keripik-pisang-coklat',
                'description' => 'Keripik pisang yang dilapisi coklat premium. Manis dan renyah.',
                'price' => 25000,
                'discount_price' => 22000,
                'stock' => 40,
                'weight' => 120,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories->skip(1)->first()?->id ?? $categories->first()->id,
                'name' => 'Kacang Telur Garam',
                'slug' => 'kacang-telur-garam',
                'description' => 'Kacang telur dengan taburan garam yang gurih. Camilan favorit keluarga.',
                'price' => 18000,
                'discount_price' => null,
                'stock' => 90,
                'weight' => 200,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $categories->skip(1)->first()?->id ?? $categories->first()->id,
                'name' => 'Kacang Telur Pedas Manis',
                'slug' => 'kacang-telur-pedas-manis',
                'description' => 'Kacang telur dengan campuran rasa pedas dan manis yang unik.',
                'price' => 19000,
                'discount_price' => 17000,
                'stock' => 70,
                'weight' => 200,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories->skip(2)->first()?->id ?? $categories->first()->id,
                'name' => 'Permen Jelly Mix',
                'slug' => 'permen-jelly-mix',
                'description' => 'Koleksi permen jelly dengan berbagai rasa. Cocok untuk anak-anak.',
                'price' => 12000,
                'discount_price' => null,
                'stock' => 120,
                'weight' => 80,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $categories->skip(2)->first()?->id ?? $categories->first()->id,
                'name' => 'Permen Lolipop Asam',
                'slug' => 'permen-lolipop-asam',
                'description' => 'Lolipop dengan rasa asam yang menyegarkan. Cocok untuk menghilangkan dahaga.',
                'price' => 8000,
                'discount_price' => 6000,
                'stock' => 150,
                'weight' => 50,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories->first()->id,
                'name' => 'Keripik Kentang BBQ',
                'slug' => 'keripik-kentang-bbq',
                'description' => 'Keripik kentang dengan rasa BBQ yang smoky dan lezat.',
                'price' => 18000,
                'discount_price' => 16000,
                'stock' => 75,
                'weight' => 100,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories->skip(1)->first()?->id ?? $categories->first()->id,
                'name' => 'Kacang Almond Panggang',
                'slug' => 'kacang-almond-panggang',
                'description' => 'Kacang almond premium yang dipanggang dengan garam laut.',
                'price' => 25000,
                'discount_price' => null,
                'stock' => 50,
                'weight' => 150,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categories->skip(2)->first()?->id ?? $categories->first()->id,
                'name' => 'Permen Jelly Strawberry',
                'slug' => 'permen-jelly-strawberry',
                'description' => 'Permen jelly rasa stroberi yang manis dan segar.',
                'price' => 10000,
                'discount_price' => 8000,
                'stock' => 100,
                'weight' => 80,
                'is_active' => true,
                'is_featured' => true,
            ],
            

        ];


        foreach ($products as $productData) {
            $product = Product::create($productData);

            // Buat gambar produk placeholder
            \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/placeholder.jpg',
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }

        $this->command->info('Berhasil membuat ' . count($products) . ' produk sample dengan gambar.');
    }
}