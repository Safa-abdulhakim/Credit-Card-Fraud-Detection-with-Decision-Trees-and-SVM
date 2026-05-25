@extends('layouts.vendor')
@section('title','Add Product')
@section('page-title','Add New Product')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Basic Information</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Product Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Premium Wireless Headphones">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Short Description</label>
                        <textarea name="short_description" class="form-control" rows="2" placeholder="Brief product description (shown in listings)">{{ old('short_description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Description</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Detailed product description">{{ old('description') }}</textarea>
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
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" step="0.01" min="0" required>
                            </div>
                            @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Sale Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price') }}" step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Stock Quantity *</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity',0) }}" min="0" required>
                            @error('quantity')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Low Stock Threshold</label>
                            <input type="number" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold',5) }}" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">SKU</label>
                            <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" placeholder="Auto-generated if blank">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Weight (kg)</label>
                            <input type="number" name="weight" class="form-control" value="{{ old('weight') }}" step="0.01" min="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Images</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thumbnail *</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*" required>
                        <small class="text-muted">Main product image (recommended: 800×800px)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Additional Images</label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                        <small class="text-muted">Upload up to 8 additional images</small>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-3 mb-4">
                <button type="submit" name="status" value="active" class="btn btn-success px-4"><i class="fas fa-check me-2"></i>Publish Product</button>
                <button type="submit" name="status" value="draft" class="btn btn-outline-secondary px-4">Save as Draft</button>
                <a href="{{ route('vendor.products.index') }}" class="btn btn-outline-danger px-4">Cancel</a>
            </div>
        </form>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Organisation</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Category *</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">Select category...</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id')==$category->id?'selected':'' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Brand</label>
                    <select name="brand_id" class="form-select">
                        <option value="">No Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id')==$brand->id?'selected':'' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured" {{ old('is_featured')?'checked':'' }}>
                        <label class="form-check-label" for="featured">Featured Product</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">SEO</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
