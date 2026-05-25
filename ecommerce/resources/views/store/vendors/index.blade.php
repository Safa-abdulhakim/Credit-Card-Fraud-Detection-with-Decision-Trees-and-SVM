@extends('layouts.app')
@section('title','All Vendors')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Our Vendors</h2>
    <div class="row g-4">
        @forelse($vendors as $vendor)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-4">
                <div class="display-4 mb-2">🏪</div>
                <h5 class="fw-bold">{{ $vendor->store_name }}</h5>
                <p class="text-muted small">{{ Str::limit($vendor->description,80) }}</p>
                <p class="small text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $vendor->city }}, {{ $vendor->country }}</p>
                <a href="{{ route('vendors.show',$vendor->slug) }}" class="btn btn-outline-primary btn-sm mt-2">Visit Store</a>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5"><h5 class="text-muted">No vendors found</h5></div>
        @endforelse
    </div>
    <div class="mt-4 d-flex justify-content-center">{{ $vendors->links() }}</div>
</div>
@endsection
