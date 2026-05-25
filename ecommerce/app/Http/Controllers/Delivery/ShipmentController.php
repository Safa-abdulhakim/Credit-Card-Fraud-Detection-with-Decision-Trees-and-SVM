<?php
namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $agent = auth()->user()->deliveryAgent;
        $shipments = Shipment::with('order.user', 'order.shippingAddress')
            ->where('delivery_agent_id', $agent?->id)
            ->paginate(15);
        return view('delivery.shipments.index', compact('shipments'));
    }

    public function updateStatus(Request $request, Shipment $shipment)
    {
        $request->validate(['status' => 'required|in:shipped,in_transit,delivered,returned']);
        $shipment->update([
            'status'       => $request->status,
            'delivered_at' => $request->status === 'delivered' ? now() : null,
        ]);

        if ($request->status === 'delivered') {
            $shipment->order->update(['status' => 'delivered']);
        }

        return back()->with('success', 'Shipment status updated.');
    }
}
