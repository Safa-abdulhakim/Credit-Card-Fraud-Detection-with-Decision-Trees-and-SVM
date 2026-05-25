@extends('layouts.admin')
@section('title','Edit Category')
@section('page-title','Edit Category')
@section('content')
<div style="max-width:600px;">
    <div class="table-card">
        <form action="{{ route('admin.categories.update',$category) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3"><label class="form-label fw-semibold">Name *</label><input type="text" name="name" class="form-control" value="{{ old('name',$category->name) }}" required></div>
            <div class="mb-3"><label class="form-label fw-semibold">Parent Category</label><select name="parent_id" class="form-select"><option value="">None</option>@foreach($parents as $p)<option value="{{ $p->id }}" {{ $category->parent_id==$p->id?'selected':'' }}>{{ $p->name }}</option>@endforeach</select></div>
            <div class="mb-3"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description',$category->description) }}</textarea></div>
            <div class="mb-4"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="active" {{ $category->is_active?'checked':'' }}><label class="form-check-label" for="active">Active</label></div></div>
            <div class="d-flex gap-2"><button type="submit" class="btn btn-primary px-4">Update</button><a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary px-4">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
