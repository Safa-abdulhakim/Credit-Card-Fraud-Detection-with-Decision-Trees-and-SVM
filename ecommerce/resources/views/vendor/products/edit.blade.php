@extends('layouts.vendor')
@section('title','Edit Product')
@section('page-title','Edit Product')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('vendor.products.update',$product) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Basic Information</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Product Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$product->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Short Description</label>
                        <textarea name="short_description" class="form-control" rows="2">{{ old('short_description',$product->short_description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Description</label>
                        <textarea name="description" class="form-control" rows="5">{{ old('description',$product->description) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Pricing & Inventory</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Price *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price" class="form-control" value="{{ old('price',$product->price) }}" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Sale Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price',$product->discount_price) }}" step="0.01" min="0">
                            </div>
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
                            <label class="form-label fw-semibold">SKU</label>
                            <input type="text" name="sku" class="form-control" value="{{ old('sku',$product->sku) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Weight (kg)</label>
                            <input type="number" name="weight" class="form-control" value="{{ old('weight',$product->weight) }}" step="0.01" min="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Images</div>
                <div class="card-body">
                    @if($product->thumbnail)
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Current Thumbnail</label>
                        <div><img src="{{ asset('storage/'.$product->thumbnail) }}" class="rounded" style="height:120px;object-fit:cover;"></div>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Replace Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>
                    @if($product->images->isNotEmpty())
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Current Images</label>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach($product->images as $img)
                            <img src="{{ asset('storage/'.$img->image_path) }}" class="rounded" style="height:80px;object-fit:cover;">
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Add More Images</label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-3 mb-4">
                <button type="submit" class="btn btn-success px-4"><i class="fas fa-save me-2"></i>Update Product</button>
                <a href="{{ route('vendor.products.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Organisation</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Category *</label>
                    <select name="category_id" class="form-select" form="main-form" required>
                        <option value="">Select category...</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id==$category->id?'selected':'' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Brand</label>
                    <select name="brand_id" class="form-select" form="main-form">
                        <option value="">No Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $product->brand_id==$brand->id?'selected':'' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select" form="main-form">
                        <option value="active" {{ $product->status==='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ $product->status==='inactive'?'selected':'' }}>Inactive</option>
                        <option value="draft" {{ $product->status==='draft'?'selected':'' }}>Draft</option>
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured" {{ $product->is_featured?'checked':'' }}>
                    <label class="form-check-label" for="featured">Featured Product</label>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Stats</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2 small"><span>Total Sold</span><span class="fw-bold">{{ $product->sold_count }}</span></div>
                <div class="d-flex justify-content-between mb-2 small"><span>Rating</span><span class="fw-bold">{{ number_format($product->rating_avg,1) }} ⭐ ({{ $product->rating_count }})</span></div>
                <div class="d-flex justify-content-between small"><span>Created</span><span>{{ $product->created_at->format('M d, Y') }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
