@extends('layouts.admin')
@section('title', 'تعديل القسم')
@section('page-title', 'تعديل القسم')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.departments.index') }}">الأقسام</a></li>
    <li class="breadcrumb-item active">تعديل</li>
@endsection
@section('content')
<div class="card" style="max-width:600px;"><div class="card-header d-flex align-items-center justify-content-between"><h6 class="mb-0 fw-semibold"><i class="fas fa-building me-2 text-primary"></i>تعديل: {{ $department->name }}</h6><a href="{{ route('admin.departments.show', $department) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>رجوع</a></div><div class="card-body">
<form action="{{ route('admin.departments.update', $department) }}" method="POST">@csrf @method('PUT')
<div class="row g-3">
<div class="col-12"><label class="form-label fw-semibold">اسم القسم <span class="text-danger">*</span></label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $department->name) }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><label class="form-label fw-semibold">الوصف</label><textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $department->description) }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><div class="form-check"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ $department->is_active ? 'checked' : '' }}><label class="form-check-label" for="is_active">نشط</label></div></div>
<div class="col-12 d-flex gap-2"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>تحديث القسم</button><a href="{{ route('admin.departments.show', $department) }}" class="btn btn-secondary">إلغاء</a></div>
</div></form></div></div>
@endsection
