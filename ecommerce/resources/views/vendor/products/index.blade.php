@extends('layouts.vendor')
@section('title','My Products')
@section('page-title','Products')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">My Products</h5>
    <a href="{{ route('vendor.products.create') }}" class="btn btn-success"><i class="fas fa-plus me-2"></i>Add Product</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status')==='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>Inactive</option>
                    <option value="draft" {{ request('status')==='draft'?'selected':'' }}>Draft</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('vendor.products.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Sales</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/'.$product->thumbnail) }}" width="48" height="48" class="rounded" style="object-fit:cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:48px;height:48px;"><i class="fas fa-image text-muted"></i></div>
                            @endif
                            <div>
                                <div class="fw-semibold">{{ Str::limit($product->name,35) }}</div>
                                <small class="text-muted font-monospace">{{ $product->sku }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="small text-muted">{{ $product->category->name }}</td>
                    <td>
                        <div class="fw-bold">${{ number_format($product->effective_price,2) }}</div>
                        @if($product->discount_price)<small class="text-muted text-decoration-line-through">${{ number_format($product->price,2) }}</small>@endif
                    </td>
                    <td>
                        @if($product->isLowStock())
                            <span class="badge bg-danger">{{ $product->available_quantity }}</span>
                        @elseif($product->isInStock())
                            <span class="badge bg-success">{{ $product->available_quantity }}</span>
                        @else
                            <span class="badge bg-secondary">Out of Stock</span>
                        @endif
                    </td>
                    <td>{{ $product->sold_count }}</td>
                    <td><span class="badge bg-{{ $product->status==='active'?'success':($product->status==='draft'?'secondary':'warning') }}">{{ ucfirst($product->status) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('product.show',$product->slug) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('vendor.products.edit',$product) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('vendor.products.destroy',$product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i>
                        <h6>No products yet</h6>
                        <a href="{{ route('vendor.products.create') }}" class="btn btn-success mt-2">Add Your First Product</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white d-flex justify-content-end">{{ $products->links() }}</div>
    @endif
</div>
@endsection
