<?php
namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\Vendor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class UpdateVendorEarnings implements ShouldQueue
{
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;

        $vendorEarnings = DB::table('order_items')
            ->where('order_id', $order->id)
            ->select('vendor_id', DB::raw('SUM(total) as total'))
            ->groupBy('vendor_id')
            ->get();

        foreach ($vendorEarnings as $earning) {
            $vendor = Vendor::find($earning->vendor_id);
            if ($vendor) {
                $commission = $earning->total * ($vendor->commission_rate / 100);
                $netEarning = $earning->total - $commission;
                $vendor->increment('total_earnings', $netEarning);
                $vendor->increment('pending_withdrawal', $netEarning);
            }
        }
    }
}
