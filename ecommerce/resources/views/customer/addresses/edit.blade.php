@extends('layouts.app')
@section('title','Edit Address')
@section('content')
<div class="container py-5" style="max-width:600px;">
    <h3 class="fw-bold mb-4">Edit Address</h3>
    <div class="card border-0 shadow-sm p-4">
        <form action="{{ route('customer.addresses.update',$address) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">First Name</label><input type="text" name="first_name" class="form-control" value="{{ old('first_name',$address->first_name) }}" required></div>
                <div class="col-md-6"><label class="form-label">Last Name</label><input type="text" name="last_name" class="form-control" value="{{ old('last_name',$address->last_name) }}" required></div>
                <div class="col-12"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone',$address->phone) }}" required></div>
                <div class="col-12"><label class="form-label">Address Line 1</label><input type="text" name="address_line1" class="form-control" value="{{ old('address_line1',$address->address_line1) }}" required></div>
                <div class="col-12"><label class="form-label">Address Line 2</label><input type="text" name="address_line2" class="form-control" value="{{ old('address_line2',$address->address_line2) }}"></div>
                <div class="col-md-6"><label class="form-label">City</label><input type="text" name="city" class="form-control" value="{{ old('city',$address->city) }}" required></div>
                <div class="col-md-6"><label class="form-label">State</label><input type="text" name="state" class="form-control" value="{{ old('state',$address->state) }}"></div>
                <div class="col-md-6"><label class="form-label">Country</label><input type="text" name="country" class="form-control" value="{{ old('country',$address->country) }}" required></div>
                <div class="col-md-6"><label class="form-label">Postal Code</label><input type="text" name="postal_code" class="form-control" value="{{ old('postal_code',$address->postal_code) }}"></div>
                <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" {{ $address->is_default?'checked':'' }}><label class="form-check-label" for="is_default">Default address</label></div></div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">Update</button>
                    <a href="{{ route('customer.addresses.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
