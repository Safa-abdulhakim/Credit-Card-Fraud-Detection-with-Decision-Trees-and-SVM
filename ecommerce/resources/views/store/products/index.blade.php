@extends('layouts.app')
@section('title','Shop All Products')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold border-bottom pb-2 mb-3">Filters</h6>
                    <form method="GET" action="{{ route('shop') }}">
                        <div class="mb-3">
                            <label class="fw-semibold small mb-1 d-block">Categories</label>
                            @foreach($categories->take(10) as $cat)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="{{ $cat->slug }}" id="cat{{$cat->id}}" {{ request('category')===$cat->slug?'checked':'' }}>
                                <label class="form-check-label small" for="cat{{$cat->id}}">{{ $cat->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold small mb-1 d-block">Brands</label>
                            @foreach($brands->take(8) as $brand)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="brand" value="{{ $brand->slug }}" id="brand{{$brand->id}}" {{ request('brand')===$brand->slug?'checked':'' }}>
                                <label class="form-check-label small" for="brand{{$brand->id}}">{{ $brand->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold small mb-1 d-block">Price Range</label>
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" name="min_price" placeholder="Min" value="{{ request('min_price') }}">
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" name="max_price" placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Apply</button>
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">Clear</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small">{{ $products->total() }} products found</span>
                <form method="GET">
                    @foreach(request()->except('sort') as $k=>$v)<input type="hidden" name="{{$k}}" value="{{$v}}">@endforeach
                    <select name="sort" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">Sort By</option>
                        <option value="newest" {{ request('sort')==='newest'?'selected':'' }}>Newest</option>
                        <option value="price_asc" {{ request('sort')==='price_asc'?'selected':'' }}>Price: Low→High</option>
                        <option value="price_desc" {{ request('sort')==='price_desc'?'selected':'' }}>Price: High→Low</option>
                        <option value="popular" {{ request('sort')==='popular'?'selected':'' }}>Most Popular</option>
                        <option value="rating" {{ request('sort')==='rating'?'selected':'' }}>Top Rated</option>
                    </select>
                </form>
            </div>
            @if($products->isEmpty())
                <div class="text-center py-5"><i class="fas fa-search fa-3x text-muted mb-3 d-block"></i><h5>No products found</h5><a href="{{ route('shop') }}" class="btn btn-primary mt-2">View All</a></div>
            @else
                <div class="row g-4">
                    @foreach($products as $product)
                    <div class="col-sm-6 col-lg-4">@include('components.product-card',['product'=>$product])</div>
                    @endforeach
                </div>
                <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
