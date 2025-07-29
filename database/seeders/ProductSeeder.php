<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Ürün 1', 'sku' => 'SKU-001', 'price' => 49.90, 'stock_quantity' => 10],
            ['name' => 'Ürün 2', 'sku' => 'SKU-002', 'price' => 99.90, 'stock_quantity' =>  8],
            ['name' => 'Ürün 3', 'sku' => 'SKU-003', 'price' => 149.90,'stock_quantity' => 5],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['sku' => $data['sku']],
                $data
            );
        }
    }
}
