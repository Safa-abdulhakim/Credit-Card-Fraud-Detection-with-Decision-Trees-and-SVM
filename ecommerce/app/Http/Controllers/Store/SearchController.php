<?php
namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query    = $request->q ?? '';
        $products = Product::with(['vendor', 'images'])
            ->where('status', 'active')
            ->where(fn($q) => $q->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%"))
            ->paginate(12);

        return view('store.search.index', compact('products', 'query'));
    }
}
