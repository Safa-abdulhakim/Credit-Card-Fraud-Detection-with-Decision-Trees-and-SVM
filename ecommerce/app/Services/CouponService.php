<?php
namespace App\Services;

use App\Models\Coupon;

class CouponService
{
    public function validate(string $code, float $cartTotal, int $userId): array
    {
        $coupon = Coupon::where('code', strtoupper($code))->first();

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid coupon code.'];
        }

        if (!$coupon->isValid()) {
            return ['valid' => false, 'message' => 'This coupon is expired or inactive.'];
        }

        if ($coupon->minimum_amount && $cartTotal < $coupon->minimum_amount) {
            return ['valid' => false, 'message' => "Minimum order amount is \${$coupon->minimum_amount}."];
        }

        $alreadyUsed = $coupon->usages()->where('user_id', $userId)->exists();
        if ($alreadyUsed) {
            return ['valid' => false, 'message' => 'You have already used this coupon.'];
        }

        $discount = $coupon->calculateDiscount($cartTotal);

        return [
            'valid'    => true,
            'coupon'   => $coupon,
            'discount' => $discount,
            'message'  => "Coupon applied! You save \${$discount}",
        ];
    }
}
