@extends('layouts.admin')
@section('title', 'إضافة قسم')
@section('page-title', 'إضافة قسم جديد')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.departments.index') }}">الأقسام</a></li>
    <li class="breadcrumb-item active">إضافة</li>
@endsection
@section('content')
<div class="card" style="max-width:600px;"><div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-building me-2 text-primary"></i>معلومات القسم</h6></div><div class="card-body">
<form action="{{ route('admin.departments.store') }}" method="POST">@csrf
<div class="row g-3">
<div class="col-12"><label class="form-label fw-semibold">اسم القسم <span class="text-danger">*</span></label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="مثال: طب القلب، طب الأطفال" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><label class="form-label fw-semibold">الوصف</label><textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="وصف مختصر للقسم...">{{ old('description') }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><div class="form-check"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" checked><label class="form-check-label" for="is_active">نشط</label></div></div>
<div class="col-12 d-flex gap-2"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>حفظ القسم</button><a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">إلغاء</a></div>
</div></form></div></div>
@endsection
