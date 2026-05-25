@extends('layouts.app')
@section('title', $brand->name)
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">{{ $brand->name }} Products</h2>
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-sm-6 col-lg-3">@include('components.product-card',['product'=>$product])</div>
        @empty
        <div class="col-12 text-center py-5"><h5 class="text-muted">No products for this brand</h5></div>
        @endforelse
    </div>
    <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
</div>
@endsection
