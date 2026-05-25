<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendorData = [
            [
                'email'       => 'vendor@ecommerce.com',
                'store_name'  => 'Tech Paradise',
                'description' => 'Best electronics and gadgets store',
                'city'        => 'New York',
                'country'     => 'US',
            ],
            [
                'email'       => 'vendor2@ecommerce.com',
                'store_name'  => 'Fashion Hub',
                'description' => 'Trendy fashion and accessories',
                'city'        => 'Los Angeles',
                'country'     => 'US',
            ],
        ];

        foreach ($vendorData as $data) {
            $user = User::where('email', $data['email'])->first();
            if ($user) {
                Vendor::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'store_name'    => $data['store_name'],
                        'slug'          => Str::slug($data['store_name']),
                        'description'   => $data['description'],
                        'city'          => $data['city'],
                        'country'       => $data['country'],
                        'status'        => 'approved',
                        'commission_rate'=> 10.00,
                    ]
                );
            }
        }
    }
}
