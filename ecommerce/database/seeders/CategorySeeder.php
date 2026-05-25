<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'children' => ['Smartphones', 'Laptops', 'Tablets', 'Accessories']],
            ['name' => 'Fashion', 'children' => ['Men\'s Clothing', 'Women\'s Clothing', 'Shoes', 'Bags']],
            ['name' => 'Home & Living', 'children' => ['Furniture', 'Kitchen', 'Decor', 'Bedding']],
            ['name' => 'Sports', 'children' => ['Fitness', 'Outdoor', 'Team Sports', 'Water Sports']],
            ['name' => 'Books', 'children' => ['Fiction', 'Non-Fiction', 'Technical', 'Children']],
        ];

        foreach ($categories as $catData) {
            $parent = Category::firstOrCreate(
                ['slug' => Str::slug($catData['name'])],
                ['name' => $catData['name'], 'is_active' => true]
            );

            foreach ($catData['children'] as $childName) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($childName)],
                    ['name' => $childName, 'parent_id' => $parent->id, 'is_active' => true]
                );
            }
        }
    }
}
