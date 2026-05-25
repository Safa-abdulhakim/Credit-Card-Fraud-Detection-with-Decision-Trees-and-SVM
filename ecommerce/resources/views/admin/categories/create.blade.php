@extends('layouts.admin')
@section('title','Add Category')
@section('page-title','Add Category')
@section('content')
<div style="max-width:600px;">
    <div class="table-card">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-3"><label class="form-label fw-semibold">Name *</label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label fw-semibold">Parent Category</label><select name="parent_id" class="form-select"><option value="">None (Top Level)</option>@foreach($parents as $p)<option value="{{ $p->id }}" {{ old('parent_id')==$p->id?'selected':'' }}>{{ $p->name }}</option>@endforeach</select></div>
            <div class="mb-3"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
            <div class="mb-3"><label class="form-label fw-semibold">Meta Title</label><input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}"></div>
            <div class="mb-3"><label class="form-label fw-semibold">Meta Description</label><textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea></div>
            <div class="mb-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="active" checked><label class="form-check-label" for="active">Active</label></div></div>
            <div class="d-flex gap-2"><button type="submit" class="btn btn-primary px-4">Create Category</button><a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary px-4">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
