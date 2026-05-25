<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (!auth()->user()->isDeliveryAgent()) {
            abort(403, 'Access denied. Delivery agent privileges required.');
        }
        return $next($request);
    }
}
