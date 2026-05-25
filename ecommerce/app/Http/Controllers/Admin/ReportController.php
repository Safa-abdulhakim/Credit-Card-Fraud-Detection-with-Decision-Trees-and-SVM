<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class ReportController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function sales()
    {
        $data = $this->reportService->getMonthlySales(12);
        return view('admin.reports.sales', compact('data'));
    }

    public function revenue()
    {
        $data = $this->reportService->getMonthlySales(12);
        return view('admin.reports.revenue', compact('data'));
    }

    public function inventory()
    {
        $lowStock = $this->reportService->getLowStockProducts(50);
        return view('admin.reports.inventory', compact('lowStock'));
    }

    public function vendors()
    {
        $stats = \App\Models\Vendor::with('user')->withCount('products')->get();
        return view('admin.reports.vendors', compact('stats'));
    }

    public function customers()
    {
        $customers = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'customer'))
            ->withCount('orders')
            ->latest()
            ->paginate(20);
        return view('admin.reports.customers', compact('customers'));
    }
}
