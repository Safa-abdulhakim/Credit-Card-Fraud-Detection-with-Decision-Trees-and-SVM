<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;
        $topProducts = Product::where('vendor_id', $vendor->id)
            ->orderByDesc('sold_count')
            ->take(10)
            ->get();
        return view('vendor.analytics', compact('vendor', 'topProducts'));
    }
}
