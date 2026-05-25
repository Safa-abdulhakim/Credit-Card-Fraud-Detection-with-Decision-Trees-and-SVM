<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class DashboardController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function index()
    {
        $stats        = $this->reportService->getDashboardStats();
        $monthlySales = $this->reportService->getMonthlySales(6);
        $latestOrders = $this->reportService->getLatestOrders(10);
        $bestProducts = $this->reportService->getBestSellingProducts(5);
        $lowStock     = $this->reportService->getLowStockProducts(5);

        return view('admin.dashboard', compact(
            'stats', 'monthlySales', 'latestOrders', 'bestProducts', 'lowStock'
        ));
    }
}
