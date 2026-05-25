@extends('layouts.vendor')
@section('title','Store Settings')
@section('page-title','Store Settings')
@section('content')
<div style="max-width:700px;">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('vendor.settings.update') }}" method="POST">
                @csrf @method('PUT')
                <h5 class="fw-bold mb-3 border-bottom pb-2">Store Information</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Store Name *</label>
                        <input type="text" name="store_name" class="form-control @error('store_name') is-invalid @enderror" value="{{ old('store_name',$vendor->store_name) }}" required>
                        @error('store_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Store Phone</label>
                        <input type="text" name="store_phone" class="form-control" value="{{ old('store_phone',$vendor->store_phone) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description',$vendor->description) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city',$vendor->city) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ old('country',$vendor->country) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address',$vendor->address) }}</textarea>
                    </div>
                </div>
                <h5 class="fw-bold mb-3 border-bottom pb-2">Banking Details</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name',$vendor->bank_name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Account Number</label>
                        <input type="text" name="bank_account_number" class="form-control" value="{{ old('bank_account_number',$vendor->bank_account_number) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Account Holder Name</label>
                        <input type="text" name="bank_account_name" class="form-control" value="{{ old('bank_account_name',$vendor->bank_account_name) }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-success px-5"><i class="fas fa-save me-2"></i>Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection
