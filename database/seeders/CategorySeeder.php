<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Keripik & Snack Kentang',
                'slug' => 'keripik-snack-kentang',
                'description' => 'Koleksi keripik dan snack kentang dengan berbagai rasa',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Kacang & Biji-bijian',
                'slug' => 'kacang-biji-bijian',
                'description' => 'Berbagai jenis kacang dan biji-bijian yang gurih',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Permen & Jelly',
                'slug' => 'permen-jelly',
                'description' => 'Permen dan jelly dengan berbagai rasa untuk semua umur',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Camilan Tradisional',
                'slug' => 'camilan-tradisional',
                'description' => 'Camilan tradisional Indonesia yang lezat',
                'image' => null,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        $this->command->info('Berhasil membuat ' . count($categories) . ' kategori sample.');
    }
}