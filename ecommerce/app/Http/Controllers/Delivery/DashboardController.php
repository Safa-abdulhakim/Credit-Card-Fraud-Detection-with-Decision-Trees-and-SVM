<?php
namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Shipment;

class DashboardController extends Controller
{
    public function index()
    {
        $agent = auth()->user()->deliveryAgent;
        $shipments = Shipment::with('order.user')
            ->where('delivery_agent_id', $agent?->id)
            ->latest()
            ->take(10)
            ->get();
        return view('delivery.dashboard', compact('agent', 'shipments'));
    }
}
