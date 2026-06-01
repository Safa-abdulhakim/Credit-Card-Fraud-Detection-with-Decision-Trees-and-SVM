@extends('layouts.app')
@php $isAr = app()->getLocale() === 'ar'; @endphp
@section('title', $isAr ? 'تسوق جميع المنتجات' : 'Shop All Products')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold border-bottom pb-2 mb-3">{{ $isAr ? 'الفلاتر' : 'Filters' }}</h6>
                    <form method="GET" action="{{ route('shop') }}">
                        <div class="mb-3">
                            <label class="fw-semibold small mb-1 d-block">{{ $isAr ? 'الفئات' : 'Categories' }}</label>
                            @foreach($categories->take(10) as $cat)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="{{ $cat->slug }}" id="cat{{$cat->id}}" {{ request('category')===$cat->slug?'checked':'' }}>
                                <label class="form-check-label small" for="cat{{$cat->id}}">{{ $cat->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold small mb-1 d-block">{{ $isAr ? 'الماركات' : 'Brands' }}</label>
                            @foreach($brands->take(8) as $brand)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="brand" value="{{ $brand->slug }}" id="brand{{$brand->id}}" {{ request('brand')===$brand->slug?'checked':'' }}>
                                <label class="form-check-label small" for="brand{{$brand->id}}">{{ $brand->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold small mb-1 d-block">{{ $isAr ? 'نطاق السعر' : 'Price Range' }}</label>
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" name="min_price" placeholder="{{ $isAr ? 'الأدنى' : 'Min' }}" value="{{ request('min_price') }}">
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" name="max_price" placeholder="{{ $isAr ? 'الأعلى' : 'Max' }}" value="{{ request('max_price') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">{{ $isAr ? 'تطبيق' : 'Apply' }}</button>
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">{{ $isAr ? 'مسح' : 'Clear' }}</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small">{{ $products->total() }} {{ $isAr ? 'منتج' : 'products found' }}</span>
                <form method="GET">
                    @foreach(request()->except('sort') as $k=>$v)<input type="hidden" name="{{$k}}" value="{{$v}}">@endforeach
                    <select name="sort" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                        <option value="">{{ $isAr ? 'ترتيب حسب' : 'Sort By' }}</option>
                        <option value="newest" {{ request('sort')==='newest'?'selected':'' }}>{{ $isAr ? 'الأحدث' : 'Newest' }}</option>
                        <option value="price_asc" {{ request('sort')==='price_asc'?'selected':'' }}>{{ $isAr ? 'السعر: الأقل أولاً' : 'Price: Low→High' }}</option>
                        <option value="price_desc" {{ request('sort')==='price_desc'?'selected':'' }}>{{ $isAr ? 'السعر: الأعلى أولاً' : 'Price: High→Low' }}</option>
                        <option value="popular" {{ request('sort')==='popular'?'selected':'' }}>{{ $isAr ? 'الأكثر شعبية' : 'Most Popular' }}</option>
                        <option value="rating" {{ request('sort')==='rating'?'selected':'' }}>{{ $isAr ? 'الأعلى تقييماً' : 'Top Rated' }}</option>
                    </select>
                </form>
            </div>
            @if($products->isEmpty())
                <div class="text-center py-5"><i class="fas fa-search fa-3x text-muted mb-3 d-block"></i><h5>{{ $isAr ? 'لا توجد منتجات' : 'No products found' }}</h5><a href="{{ route('shop') }}" class="btn btn-primary mt-2">{{ $isAr ? 'عرض الكل' : 'View All' }}</a></div>
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
