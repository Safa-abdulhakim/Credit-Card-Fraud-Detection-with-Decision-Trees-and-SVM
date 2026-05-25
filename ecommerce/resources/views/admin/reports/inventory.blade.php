@extends('layouts.admin')
@section('title','Inventory Report')
@section('page-title','Inventory Report')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="h4 text-primary mb-0">{{ $stats['total_products'] ?? 0 }}</div>
            <small class="text-muted">Total Products</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="h4 text-success mb-0">{{ $stats['in_stock'] ?? 0 }}</div>
            <small class="text-muted">In Stock</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="h4 text-warning mb-0">{{ $stats['low_stock'] ?? 0 }}</div>
            <small class="text-muted">Low Stock</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="h4 text-danger mb-0">{{ $stats['out_of_stock'] ?? 0 }}</div>
            <small class="text-muted">Out of Stock</small>
        </div>
    </div>
</div>
<div class="table-card">
    <h6 class="fw-bold mb-3">Low Stock & Out of Stock Products</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Product</th><th>Vendor</th><th>Category</th><th>Stock</th><th>Threshold</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($lowStockProducts ?? [] as $product)
                <tr>
                    <td class="fw-semibold">{{ Str::limit($product->name,40) }}</td>
                    <td class="small text-muted">{{ $product->vendor->store_name }}</td>
                    <td class="small text-muted">{{ $product->category->name }}</td>
                    <td>
                        <span class="badge bg-{{ $product->available_quantity==0?'danger':'warning' }}">
                            {{ $product->available_quantity }}
                        </span>
                    </td>
                    <td class="small">{{ $product->low_stock_threshold }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit',$product) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-success">
                        <i class="fas fa-check-circle fa-2x d-block mb-2"></i>
                        All products are well stocked!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
