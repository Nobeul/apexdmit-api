<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Apple iPhone 13',
                'price' => 799.00,
                'stock' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Samsung Galaxy S21',
                'price' => 650.50,
                'stock' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sony WH-1000XM4 Headphones',
                'price' => 348.00,
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Apple MacBook Pro 14"',
                'price' => 1999,
                'stock' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Samsung 55" 4K UHD Smart TV',
                'price' => 650.00,
                'stock' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nike Air Zoom Pegasus 38',
                'price' => 120.00,
                'stock' => 250,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dell XPS 13 Laptop',
                'price' => 1300.00,
                'stock' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'GoPro HERO10 Black',
                'price' => 500.50,
                'stock' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bose QuietComfort 35 II',
                'price' => 300.00,
                'stock' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sony PlayStation 5',
                'price' => 500,
                'stock' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
