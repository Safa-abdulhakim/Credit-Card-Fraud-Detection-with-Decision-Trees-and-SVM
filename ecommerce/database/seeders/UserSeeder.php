<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole    = Role::where('name', 'admin')->first();
        $vendorRole   = Role::where('name', 'vendor')->first();
        $customerRole = Role::where('name', 'customer')->first();
        $deliveryRole = Role::where('name', 'delivery')->first();

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@ecommerce.com'],
            [
                'name'              => 'System Admin',
                'password'          => Hash::make('password'),
                'role_id'           => $adminRole->id,
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );

        // Vendors
        $vendors = [
            ['name' => 'Tech Store', 'email' => 'vendor@ecommerce.com'],
            ['name' => 'Fashion Hub', 'email' => 'vendor2@ecommerce.com'],
        ];

        foreach ($vendors as $vendor) {
            User::firstOrCreate(
                ['email' => $vendor['email']],
                [
                    'name'              => $vendor['name'],
                    'password'          => Hash::make('password'),
                    'role_id'           => $vendorRole->id,
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        // Customers
        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => "customer{$i}@ecommerce.com"],
                [
                    'name'              => "Customer {$i}",
                    'password'          => Hash::make('password'),
                    'role_id'           => $customerRole->id,
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        // Delivery Agent
        User::firstOrCreate(
            ['email' => 'delivery@ecommerce.com'],
            [
                'name'              => 'Delivery Agent',
                'password'          => Hash::make('password'),
                'role_id'           => $deliveryRole->id,
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
