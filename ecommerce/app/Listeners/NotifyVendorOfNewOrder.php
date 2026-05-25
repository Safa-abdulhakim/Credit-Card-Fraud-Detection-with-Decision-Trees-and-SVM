<?php
namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\NewOrderNotification;
use App\Models\Vendor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class NotifyVendorOfNewOrder implements ShouldQueue
{
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;
        $vendorIds = DB::table('order_items')
            ->where('order_id', $order->id)
            ->distinct()
            ->pluck('vendor_id');

        foreach ($vendorIds as $vendorId) {
            $vendor = Vendor::with('user')->find($vendorId);
            if ($vendor?->user) {
                $vendor->user->notify(new NewOrderNotification($order));
            }
        }
    }
}
