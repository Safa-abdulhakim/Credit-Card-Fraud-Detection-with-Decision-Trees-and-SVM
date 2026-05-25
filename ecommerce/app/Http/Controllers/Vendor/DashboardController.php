<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class DashboardController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function index()
    {
        $vendor = auth()->user()->vendor;
        $stats  = $this->reportService->getVendorStats($vendor->id);
        return view('vendor.dashboard', compact('vendor', 'stats'));
    }
}
