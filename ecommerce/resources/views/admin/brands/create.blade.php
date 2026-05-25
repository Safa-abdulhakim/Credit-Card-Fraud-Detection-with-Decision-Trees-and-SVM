@extends('layouts.admin')
@section('title','Add Brand')
@section('page-title','Add Brand')
@section('content')
<div style="max-width:500px;">
    <div class="table-card">
        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Brand Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
                <small class="text-muted">Recommended: 200×100px, PNG/SVG</small>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Website</label>
                <input type="url" name="website" class="form-control" value="{{ old('website') }}" placeholder="https://">
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="active" checked>
                    <label class="form-check-label" for="active">Active</label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">Create Brand</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
