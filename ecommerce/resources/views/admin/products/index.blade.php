@extends('layouts.admin')
@section('title','Products')
@section('page-title','Product Management')
@section('content')
<div class="table-card">
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}"></div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" {{ request('status')==='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>Inactive</option>
                <option value="draft" {{ request('status')==='draft'?'selected':'' }}>Draft</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="vendor_id" class="form-select">
                <option value="">All Vendors</option>
                @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}" {{ request('vendor_id')==$vendor->id?'selected':'' }}>{{ $vendor->store_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Product</th><th>Vendor</th><th>Category</th><th>Price</th><th>Stock</th><th>Sold</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($product->thumbnail)
                            <img src="{{ asset('storage/'.$product->thumbnail) }}" width="40" height="40" class="rounded" style="object-fit:cover;">
                            @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;"><i class="fas fa-image text-muted"></i></div>
                            @endif
                            <div class="fw-semibold small">{{ Str::limit($product->name,35) }}</div>
                        </div>
                    </td>
                    <td class="small text-muted">{{ $product->vendor->store_name }}</td>
                    <td class="small text-muted">{{ $product->category->name }}</td>
                    <td class="fw-bold small">${{ number_format($product->effective_price,2) }}</td>
                    <td>
                        @if($product->isLowStock())
                        <span class="badge bg-danger">{{ $product->available_quantity }}</span>
                        @else
                        <span class="badge bg-success">{{ $product->available_quantity }}</span>
                        @endif
                    </td>
                    <td>{{ $product->sold_count }}</td>
                    <td><span class="badge bg-{{ $product->status==='active'?'success':'secondary' }}">{{ ucfirst($product->status) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('product.show',$product->slug) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.products.edit',$product) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.products.destroy',$product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No products found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $products->links() }}</div>
</div>
@endsection
