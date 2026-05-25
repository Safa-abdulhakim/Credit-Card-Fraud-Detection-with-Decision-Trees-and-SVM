<?php
namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\ReportService;

class HomeController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function index()
    {
        $featuredProducts = Product::with(['vendor', 'category', 'images'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = Product::with(['vendor', 'category', 'images'])
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->withCount('products')
            ->get();

        $bestSelling = $this->reportService->getBestSellingProducts(8);

        return view('store.home', compact('featuredProducts', 'latestProducts', 'categories', 'bestSelling'));
    }
}
