<?php
namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            ['code' => 'WELCOME10', 'type' => 'percentage', 'value' => 10, 'minimum_amount' => 50],
            ['code' => 'SAVE20',    'type' => 'percentage', 'value' => 20, 'minimum_amount' => 100],
            ['code' => 'FLAT50',    'type' => 'fixed',      'value' => 50, 'minimum_amount' => 200],
            ['code' => 'NEW25',     'type' => 'percentage', 'value' => 25, 'minimum_amount' => 75],
        ];

        foreach ($coupons as $coupon) {
            Coupon::firstOrCreate(
                ['code' => $coupon['code']],
                [
                    'type'           => $coupon['type'],
                    'value'          => $coupon['value'],
                    'minimum_amount' => $coupon['minimum_amount'],
                    'usage_limit'    => 100,
                    'is_active'      => true,
                    'expires_at'     => now()->addYear(),
                ]
            );
        }
    }
}
