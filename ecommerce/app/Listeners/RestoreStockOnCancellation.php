<?php
namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Services\ProductService;
use Illuminate\Contracts\Queue\ShouldQueue;

class RestoreStockOnCancellation implements ShouldQueue
{
    public function __construct(private ProductService $productService) {}

    public function handle(OrderCancelled $event): void
    {
        foreach ($event->order->items as $item) {
            $this->productService->adjustStock(
                $item->product,
                $item->quantity,
                'stock_restored',
                $event->order->id,
                'Stock restored due to order cancellation'
            );
        }
    }
}
