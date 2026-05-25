<?php
namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $vendor   = Vendor::first();
        $category = Category::where('parent_id', '!=', null)->first();
        $brand    = Brand::first();

        if (!$vendor || !$category) return;

        $products = [
            ['name' => 'iPhone 15 Pro', 'price' => 999.99, 'discount_price' => 899.99, 'quantity' => 50],
            ['name' => 'Samsung Galaxy S24', 'price' => 799.99, 'discount_price' => null, 'quantity' => 35],
            ['name' => 'MacBook Pro M3', 'price' => 1999.99, 'discount_price' => 1849.99, 'quantity' => 20],
            ['name' => 'Sony WH-1000XM5', 'price' => 349.99, 'discount_price' => 299.99, 'quantity' => 100],
            ['name' => 'iPad Air', 'price' => 599.99, 'discount_price' => null, 'quantity' => 45],
            ['name' => 'Apple Watch Series 9', 'price' => 399.99, 'discount_price' => 349.99, 'quantity' => 60],
            ['name' => 'Dell XPS 15', 'price' => 1599.99, 'discount_price' => null, 'quantity' => 15],
            ['name' => 'LG OLED TV 55"', 'price' => 1299.99, 'discount_price' => 1099.99, 'quantity' => 10],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(
                ['sku' => 'SKU-' . strtoupper(Str::random(8))],
                [
                    'vendor_id'       => $vendor->id,
                    'category_id'     => $category->id,
                    'brand_id'        => $brand?->id,
                    'name'            => $productData['name'],
                    'slug'            => Str::slug($productData['name']) . '-' . Str::random(4),
                    'description'     => "High-quality {$productData['name']} with premium features and excellent performance.",
                    'short_description' => "Premium {$productData['name']}",
                    'price'           => $productData['price'],
                    'discount_price'  => $productData['discount_price'],
                    'quantity'        => $productData['quantity'],
                    'status'          => 'active',
                    'is_featured'     => rand(0, 1),
                    'rating_avg'      => rand(35, 50) / 10,
                    'rating_count'    => rand(10, 200),
                    'sold_count'      => rand(5, 100),
                ]
            );
        }
    }
}
