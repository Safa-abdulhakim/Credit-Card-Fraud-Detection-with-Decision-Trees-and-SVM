<?php
namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['name' => 'Standard Shipping', 'carrier' => 'FedEx',  'base_cost' => 5.99,  'estimated_days' => 7],
            ['name' => 'Express Shipping',  'carrier' => 'UPS',    'base_cost' => 14.99, 'estimated_days' => 3],
            ['name' => 'Overnight Shipping','carrier' => 'DHL',    'base_cost' => 29.99, 'estimated_days' => 1],
            ['name' => 'Free Shipping',     'carrier' => null,     'base_cost' => 0,     'estimated_days' => 10],
        ];

        foreach ($methods as $method) {
            ShippingMethod::firstOrCreate(
                ['name' => $method['name']],
                array_merge($method, ['is_active' => true])
            );
        }
    }
}
