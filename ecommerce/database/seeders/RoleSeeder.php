<?php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin',    'display_name' => 'Administrator', 'description' => 'Full system access'],
            ['name' => 'vendor',   'display_name' => 'Vendor/Seller',  'description' => 'Can manage store and products'],
            ['name' => 'customer', 'display_name' => 'Customer',       'description' => 'Can browse and purchase products'],
            ['name' => 'delivery', 'display_name' => 'Delivery Agent',  'description' => 'Can manage shipments'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
