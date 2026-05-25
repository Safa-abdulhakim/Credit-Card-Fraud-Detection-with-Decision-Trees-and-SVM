@extends('layouts.admin')
@section('title','Add Shipping Method')
@section('page-title','Add Shipping Method')
@section('content')
<div style="max-width:500px;">
    <div class="table-card">
        <form action="{{ route('admin.shipping.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Standard Shipping">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Carrier</label>
                <input type="text" name="carrier" class="form-control" value="{{ old('carrier') }}" placeholder="e.g. FedEx, UPS, DHL">
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Base Cost ($)</label>
                    <input type="number" name="base_cost" class="form-control" value="{{ old('base_cost',0) }}" step="0.01" min="0">
                    <small class="text-muted">Set to 0 for FREE shipping</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Estimated Days</label>
                    <input type="number" name="estimated_days" class="form-control" value="{{ old('estimated_days',3) }}" min="1">
                </div>
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="active" checked>
                    <label class="form-check-label" for="active">Active</label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">Create Method</button>
                <a href="{{ route('admin.shipping.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
