<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\DTOs\CheckoutDTO;
use App\Events\OrderPlaced;
use App\Events\OrderCancelled;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(private ProductService $productService) {}

    public function createFromCart(Cart $cart, CheckoutDTO $dto, int $userId): Order
    {
        return DB::transaction(function () use ($cart, $dto, $userId) {
            $subtotal = 0;
            $items = [];

            foreach ($cart->items->load('product', 'variant') as $cartItem) {
                $product = $cartItem->product;
                if (!$this->productService->reserveStock($product, $cartItem->quantity)) {
                    throw new \RuntimeException("Insufficient stock for: {$product->name}");
                }

                $price    = $cartItem->variant?->price ?? $product->effective_price;
                $total    = $price * $cartItem->quantity;
                $subtotal += $total;

                $items[] = [
                    'product_id'   => $product->id,
                    'vendor_id'    => $product->vendor_id,
                    'variant_id'   => $cartItem->variant_id,
                    'product_name' => $product->name,
                    'quantity'     => $cartItem->quantity,
                    'price'        => $price,
                    'total'        => $total,
                ];
            }

            $discount = 0;
            $coupon   = null;
            if ($dto->couponCode) {
                $coupon = Coupon::where('code', $dto->couponCode)->first();
                if ($coupon && $coupon->isValid()) {
                    $discount = $coupon->calculateDiscount($subtotal);
                }
            }

            $tax      = round($subtotal * 0.15, 2);
            $shipping = $dto->shippingCost ?? 10.00;
            $total    = max(0, $subtotal + $tax + $shipping - $discount);

            $order = Order::create([
                'order_number'       => $this->generateOrderNumber(),
                'user_id'            => $userId,
                'shipping_address_id'=> $dto->addressId,
                'coupon_id'          => $coupon?->id,
                'status'             => Order::STATUS_PENDING,
                'subtotal'           => $subtotal,
                'tax_amount'         => $tax,
                'shipping_amount'    => $shipping,
                'discount_amount'    => $discount,
                'total'              => $total,
                'payment_method'     => $dto->paymentMethod,
                'notes'              => $dto->notes,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            if ($coupon) {
                $coupon->increment('usage_count');
                $coupon->usages()->create(['user_id' => $userId, 'order_id' => $order->id]);
            }

            $cart->items()->delete();

            event(new OrderPlaced($order));

            return $order;
        });
    }

    public function updateStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);

        if ($status === Order::STATUS_DELIVERED) {
            foreach ($order->items as $item) {
                $item->product->increment('sold_count', $item->quantity);
                $this->productService->releaseReservedStock($item->product, $item->quantity);
                $item->product->decrement('quantity', $item->quantity);
            }
        }

        if ($status === Order::STATUS_CANCELLED) {
            foreach ($order->items as $item) {
                $this->productService->releaseReservedStock($item->product, $item->quantity);
            }
            event(new OrderCancelled($order));
        }

        return $order->fresh();
    }

    public function processPayment(Order $order, string $method, array $paymentData = []): Payment
    {
        $payment = Payment::create([
            'order_id'       => $order->id,
            'user_id'        => $order->user_id,
            'payment_method' => $method,
            'amount'         => $order->total,
            'currency'       => 'USD',
            'status'         => 'completed',
            'payment_data'   => $paymentData,
            'paid_at'        => now(),
        ]);

        $this->updateStatus($order, Order::STATUS_PAID);

        return $payment;
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }
}
