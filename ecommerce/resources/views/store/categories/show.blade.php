@extends('layouts.app')
@section('title', $category->name)
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-2">{{ $category->name }}</h2>
    @if($category->description)<p class="text-muted mb-4">{{ $category->description }}</p>@endif
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-sm-6 col-lg-3">@include('components.product-card',['product'=>$product])</div>
        @empty
        <div class="col-12 text-center py-5"><i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i><h5>No products in this category</h5></div>
        @endforelse
    </div>
    <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
</div>
@endsection
