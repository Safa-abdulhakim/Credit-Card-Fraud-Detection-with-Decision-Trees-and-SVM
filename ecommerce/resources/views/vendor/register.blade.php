@extends('layouts.app')
@section('title','Become a Vendor')
@section('content')
<div class="container py-5" style="max-width:700px;">
    <div class="text-center mb-5">
        <h2 class="fw-bold">🏪 Become a Vendor</h2>
        <p class="text-muted">Set up your store and start selling to thousands of customers</p>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('vendor.register.store') }}" method="POST">
                @csrf
                <h5 class="fw-bold mb-3 border-bottom pb-2">Store Information</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Store Name *</label>
                        <input type="text" name="store_name" class="form-control @error('store_name') is-invalid @enderror" value="{{ old('store_name') }}" placeholder="e.g. Ahmed's Electronics" required>
                        @error('store_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Store Phone</label>
                        <input type="text" name="store_phone" class="form-control" value="{{ old('store_phone') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Store Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe your store...">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ old('country') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>
                </div>
                <h5 class="fw-bold mb-3 border-bottom pb-2">Banking Details</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Account Number</label>
                        <input type="text" name="bank_account_number" class="form-control" value="{{ old('bank_account_number') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Account Holder Name</label>
                        <input type="text" name="bank_account_name" class="form-control" value="{{ old('bank_account_name') }}">
                    </div>
                </div>
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="agree" required>
                        <label class="form-check-label" for="agree">I agree to the <a href="#">Vendor Terms & Conditions</a></label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-lg w-100">Submit Application</button>
                <p class="text-muted text-center small mt-3">Your application will be reviewed within 24-48 hours</p>
            </form>
        </div>
    </div>
</div>
@endsection
