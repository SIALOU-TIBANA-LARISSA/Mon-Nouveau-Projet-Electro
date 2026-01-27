<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ImportProductsFromCsvSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/products.csv');

        if (!File::exists($path)) {
            $this->command->error('products.csv introuvable');
            return;
        }

        $rows = array_map('str_getcsv', file($path));
        $header = array_map('trim', array_shift($rows));

        foreach ($rows as $row) {
            if (count($row) !== count($header)) {
                continue; // ignore les lignes mal formées
            }

            $data = array_combine($header, $row);

            DB::table('products')->insert([
                // ⚠️ on laisse PostgreSQL gérer l'id
                'category_id'     => (int) $data['category_id'],
                'name'            => $data['name'],
                'slug'            => $data['slug'],
                'description'     => $data['description'] !== 'NULL' ? $data['description'] : null,
                'price'           => (float) $data['price'],
                'stock_quantity'  => (int) $data['stock_quantity'],
                'is_published'    => (bool) $data['is_published'],
                'main_image_url'  => $data['main_image_url'],
                'sku'             => $data['sku'],
                'created_at'      => $data['created_at'] ? Carbon::parse($data['created_at']) : now(),
                'updated_at'      => $data['updated_at'] ? Carbon::parse($data['updated_at']) : now(),
            ]);
        }
    }
}

