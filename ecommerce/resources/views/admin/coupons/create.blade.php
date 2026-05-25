@extends('layouts.admin')
@section('title','Create Coupon')
@section('page-title','Create Coupon')
@section('content')
<div style="max-width:600px;">
    <div class="table-card">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            <div class="mb-3"><label class="form-label fw-semibold">Coupon Code *</label><input type="text" name="code" class="form-control font-monospace text-uppercase @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="e.g. SUMMER20" required>@error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="row g-3 mb-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Type *</label><select name="type" class="form-select" required><option value="percentage">Percentage (%)</option><option value="fixed">Fixed Amount ($)</option></select></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Value *</label><input type="number" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" step="0.01" min="0" required>@error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6"><label class="form-label">Minimum Order ($)</label><input type="number" name="minimum_amount" class="form-control" value="{{ old('minimum_amount') }}" step="0.01" min="0"></div>
                <div class="col-md-6"><label class="form-label">Usage Limit</label><input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit') }}" min="1" placeholder="Unlimited"></div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6"><label class="form-label">Start Date</label><input type="datetime-local" name="starts_at" class="form-control" value="{{ old('starts_at') }}"></div>
                <div class="col-md-6"><label class="form-label">Expiry Date</label><input type="datetime-local" name="expires_at" class="form-control" value="{{ old('expires_at') }}"></div>
            </div>
            <div class="mb-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="active" checked><label class="form-check-label" for="active">Active</label></div></div>
            <div class="d-flex gap-2"><button type="submit" class="btn btn-primary px-4">Create Coupon</button><a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary px-4">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
