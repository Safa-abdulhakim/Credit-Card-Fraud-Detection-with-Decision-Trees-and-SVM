@extends('layouts.app')
@section('title', $vendor->store_name)
@section('content')
<div class="bg-success bg-gradient text-white py-5 mb-4">
    <div class="container text-center">
        <div class="display-4 mb-2">🏪</div>
        <h2 class="fw-bold">{{ $vendor->store_name }}</h2>
        <p class="mb-0">{{ $vendor->description }}</p>
        @if($vendor->city)<small><i class="fas fa-map-marker-alt me-1"></i>{{ $vendor->city }}, {{ $vendor->country }}</small>@endif
    </div>
</div>
<div class="container pb-5">
    <h4 class="fw-bold mb-4">Products ({{ $products->total() }})</h4>
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-sm-6 col-lg-3">@include('components.product-card',['product'=>$product])</div>
        @empty
        <div class="col-12 text-center py-4"><h5 class="text-muted">No products yet</h5></div>
        @endforelse
    </div>
    <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
</div>
@endsection
