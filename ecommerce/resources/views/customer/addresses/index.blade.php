@extends('layouts.app')
@section('title','My Addresses')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Saved Addresses</h3>
        <a href="{{ route('customer.addresses.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Address</a>
    </div>
    @if($addresses->isEmpty())
        <div class="text-center py-5"><i class="fas fa-map-marker-alt fa-4x text-muted mb-4 d-block"></i><h5>No addresses saved</h5><a href="{{ route('customer.addresses.create') }}" class="btn btn-primary mt-3">Add Address</a></div>
    @else
        <div class="row g-4">
            @foreach($addresses as $address)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 {{ $address->is_default?'border-primary border-2':'' }}">
                    <div class="card-body">
                        @if($address->is_default)<span class="badge bg-primary mb-2">Default</span>@endif
                        <h6 class="fw-bold">{{ $address->full_name }}</h6>
                        <p class="text-muted mb-1 small">{{ $address->address_line1 }}@if($address->address_line2), {{ $address->address_line2 }}@endif</p>
                        <p class="text-muted mb-1 small">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                        <p class="text-muted mb-2 small">{{ $address->country }}</p>
                        <p class="small"><i class="fas fa-phone me-1"></i>{{ $address->phone }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('customer.addresses.edit',$address) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit me-1"></i>Edit</a>
                            <form action="{{ route('customer.addresses.destroy',$address) }}" method="POST" onsubmit="return confirm('Delete this address?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash me-1"></i>Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
