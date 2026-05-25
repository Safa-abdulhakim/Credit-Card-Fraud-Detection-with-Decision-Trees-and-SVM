@extends('layouts.admin')
@section('title','Edit Brand')
@section('page-title','Edit Brand')
@section('content')
<div style="max-width:500px;">
    <div class="table-card">
        <form action="{{ route('admin.brands.update',$brand) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Brand Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$brand->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            @if($brand->logo)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$brand->logo) }}" height="50" class="rounded">
            </div>
            @endif
            <div class="mb-3">
                <label class="form-label fw-semibold">Replace Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description',$brand->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Website</label>
                <input type="url" name="website" class="form-control" value="{{ old('website',$brand->website) }}">
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="active" {{ $brand->is_active?'checked':'' }}>
                    <label class="form-check-label" for="active">Active</label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">Update Brand</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
