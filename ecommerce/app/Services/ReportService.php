<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getDashboardStats(): array
    {
        return [
            'total_users'     => User::count(),
            'total_vendors'   => Vendor::count(),
            'total_products'  => Product::count(),
            'total_orders'    => Order::count(),
            'total_revenue'   => Order::where('status', 'delivered')->sum('total'),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'low_stock'       => Product::whereRaw('quantity - reserved_quantity <= low_stock_threshold')->count(),
            'today_orders'    => Order::whereDate('created_at', today())->count(),
            'today_revenue'   => Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total'),
        ];
    }

    public function getMonthlySales(int $months = 6): array
    {
        $data = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = [
                'month'   => $date->format('M Y'),
                'revenue' => Order::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->where('payment_status', 'paid')
                    ->sum('total'),
                'orders'  => Order::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        return $data;
    }

    public function getBestSellingProducts(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Product::with('vendor', 'category')
            ->orderByDesc('sold_count')
            ->limit($limit)
            ->get();
    }

    public function getLatestOrders(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Order::with(['user', 'items'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getLowStockProducts(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Product::with('vendor')
            ->whereRaw('quantity - reserved_quantity <= low_stock_threshold')
            ->where('status', 'active')
            ->limit($limit)
            ->get();
    }

    public function getVendorStats(int $vendorId): array
    {
        return [
            'total_products' => Product::where('vendor_id', $vendorId)->count(),
            'total_orders'   => DB::table('order_items')->where('vendor_id', $vendorId)->distinct('order_id')->count(),
            'total_revenue'  => DB::table('order_items')->where('vendor_id', $vendorId)->sum('total'),
            'pending_orders' => DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('order_items.vendor_id', $vendorId)
                ->where('orders.status', 'pending')
                ->count(),
        ];
    }
}
