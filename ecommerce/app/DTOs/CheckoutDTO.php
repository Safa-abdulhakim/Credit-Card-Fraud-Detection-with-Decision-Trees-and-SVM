<?php
namespace App\DTOs;

class CheckoutDTO
{
    public function __construct(
        public readonly int     $addressId,
        public readonly string  $paymentMethod,
        public readonly ?string $couponCode  = null,
        public readonly ?float  $shippingCost = null,
        public readonly ?string $notes       = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            addressId:     (int) $data['address_id'],
            paymentMethod: $data['payment_method'],
            couponCode:    $data['coupon_code'] ?? null,
            shippingCost:  isset($data['shipping_cost']) ? (float) $data['shipping_cost'] : 10.00,
            notes:         $data['notes'] ?? null,
        );
    }
}
