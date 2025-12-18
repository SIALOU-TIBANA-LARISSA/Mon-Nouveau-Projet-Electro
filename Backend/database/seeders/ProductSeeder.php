<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $products = [
            [
                'category_id' => 1,
                'name' => 'T-shirt Noir Premium',
                'slug' => 'tshirt-noir-premium',
                'description' => 'T-shirt noir personnalisable, coton 100%, impression haute qualité.',
                'price' => 5000,
                'stock_quantity' => 20,
                'is_published' => true,
                'main_image_url' => 'https://via.placeholder.com/400x400',
                'sku' => 'TSHIRT-NOIR-001',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 1,
                'name' => 'T-shirt Blanc Classique',
                'slug' => 'tshirt-blanc-classique',
                'description' => 'T-shirt blanc personnalisable, impression couleur.',
                'price' => 4500,
                'stock_quantity' => 30,
                'is_published' => true,
                'main_image_url' => 'https://via.placeholder.com/400x400',
                'sku' => 'TSHIRT-BLANC-001',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 2,
                'name' => 'Mug Blanc Personnalisé',
                'slug' => 'mug-blanc-personnalise',
                'description' => 'Mug blanc avec impression thermosensible personnalisée.',
                'price' => 3500,
                'stock_quantity' => 40,
                'is_published' => true,
                'main_image_url' => 'https://via.placeholder.com/400x400',
                'sku' => 'MUG-BLANC-002',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 3,
                'name' => 'Sticker Vinyle Rectangle',
                'slug' => 'sticker-vinyle-rectangle',
                'description' => 'Stickers en vinyle haute résistance.',
                'price' => 800,
                'stock_quantity' => 100,
                'is_published' => true,
                'main_image_url' => 'https://via.placeholder.com/300x300',
                'sku' => 'STK-RECT-003',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 4,
                'name' => 'Coque iPhone 12 Personnalisée',
                'slug' => 'coque-iphone12-personnalisee',
                'description' => 'Coque antichoc personnalisée pour iPhone 12.',
                'price' => 6000,
                'stock_quantity' => 15,
                'is_published' => true,
                'main_image_url' => 'https://via.placeholder.com/300x300',
                'sku' => 'COQUE-IP12-004',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        Product::insert($products);
    }
}
