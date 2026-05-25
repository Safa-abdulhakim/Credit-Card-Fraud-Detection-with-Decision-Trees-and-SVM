@extends('layouts.admin')
@section('title','Edit Shipping Method')
@section('page-title','Edit Shipping Method')
@section('content')
<div style="max-width:500px;">
    <div class="table-card">
        <form action="{{ route('admin.shipping.update',$method) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$method->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Carrier</label>
                <input type="text" name="carrier" class="form-control" value="{{ old('carrier',$method->carrier) }}">
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Base Cost ($)</label>
                    <input type="number" name="base_cost" class="form-control" value="{{ old('base_cost',$method->base_cost) }}" step="0.01" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Estimated Days</label>
                    <input type="number" name="estimated_days" class="form-control" value="{{ old('estimated_days',$method->estimated_days) }}" min="1">
                </div>
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="active" {{ $method->is_active?'checked':'' }}>
                    <label class="form-check-label" for="active">Active</label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">Update Method</button>
                <a href="{{ route('admin.shipping.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
