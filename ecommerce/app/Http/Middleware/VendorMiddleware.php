<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (!auth()->user()->isVendor()) {
            abort(403, 'Access denied. Vendor privileges required.');
        }
        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been suspended.');
        }
        $vendor = auth()->user()->vendor;
        if (!$vendor || $vendor->status !== 'approved') {
            return redirect()->route('vendor.pending')->with('error', 'Your store is pending approval.');
        }
        return $next($request);
    }
}
