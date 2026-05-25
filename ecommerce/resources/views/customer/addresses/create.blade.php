@extends('layouts.app')
@section('title','Add Address')
@section('content')
<div class="container py-5" style="max-width:600px;">
    <h3 class="fw-bold mb-4">Add New Address</h3>
    <div class="card border-0 shadow-sm p-4">
        <form action="{{ route('customer.addresses.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">First Name</label><input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>@error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Last Name</label><input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>@error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-12"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required></div>
                <div class="col-12"><label class="form-label">Address Line 1</label><input type="text" name="address_line1" class="form-control" value="{{ old('address_line1') }}" required></div>
                <div class="col-12"><label class="form-label">Address Line 2 <small class="text-muted">(optional)</small></label><input type="text" name="address_line2" class="form-control" value="{{ old('address_line2') }}"></div>
                <div class="col-md-6"><label class="form-label">City</label><input type="text" name="city" class="form-control" value="{{ old('city') }}" required></div>
                <div class="col-md-6"><label class="form-label">State</label><input type="text" name="state" class="form-control" value="{{ old('state') }}"></div>
                <div class="col-md-6"><label class="form-label">Country</label><input type="text" name="country" class="form-control" value="{{ old('country') }}" required></div>
                <div class="col-md-6"><label class="form-label">Postal Code</label><input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}"></div>
                <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1"><label class="form-check-label" for="is_default">Set as default address</label></div></div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">Save Address</button>
                    <a href="{{ route('customer.addresses.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
