@extends('layouts.app')
@section('title', 'Search: '.$query)
@section('content')
<div class="container py-5">
    <h4 class="fw-bold mb-4">Search results for: <span class="text-primary">"{{ $query }}"</span> <small class="text-muted fs-6">({{ $products->total() }} found)</small></h4>
    @if($products->isEmpty())
        <div class="text-center py-5"><i class="fas fa-search fa-3x text-muted mb-3 d-block"></i><h5>Nothing found for "{{ $query }}"</h5><a href="{{ route('shop') }}" class="btn btn-primary mt-2">Browse All Products</a></div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-sm-6 col-lg-3">@include('components.product-card',['product'=>$product])</div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
    @endif
</div>
@endsection
