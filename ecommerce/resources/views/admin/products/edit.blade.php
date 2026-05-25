@extends('layouts.admin')
@section('title','Edit Product')
@section('page-title','Edit Product')
@section('content')
<div style="max-width:800px;">
    <div class="table-card">
        <form action="{{ route('admin.products.update',$product) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Product Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$product->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Price *</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price',$product->price) }}" step="0.01" min="0" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Sale Price</label>
                    <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price',$product->discount_price) }}" step="0.01" min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stock Quantity *</label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity',$product->quantity) }}" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Low Stock Threshold</label>
                    <input type="number" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold',$product->low_stock_threshold) }}" min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ $product->status==='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ $product->status==='inactive'?'selected':'' }}>Inactive</option>
                        <option value="draft" {{ $product->status==='draft'?'selected':'' }}>Draft</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Category</label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Brand</label>
                    <select name="brand_id" class="form-select">
                        <option value="">No Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $product->brand_id==$brand->id?'selected':'' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Short Description</label>
                    <textarea name="short_description" class="form-control" rows="2">{{ old('short_description',$product->short_description) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Full Description</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description',$product->description) }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured" {{ $product->is_featured?'checked':'' }}>
                        <label class="form-check-label" for="featured">Featured Product</label>
                    </div>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
