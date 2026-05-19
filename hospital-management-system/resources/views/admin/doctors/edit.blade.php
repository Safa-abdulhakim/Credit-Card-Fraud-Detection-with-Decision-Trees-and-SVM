@extends('layouts.admin')
@section('title', 'تعديل بيانات الطبيب')
@section('page-title', 'تعديل بيانات الطبيب')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">الأطباء</a></li>
    <li class="breadcrumb-item active">تعديل</li>
@endsection
@section('content')
<div class="card"><div class="card-header d-flex align-items-center justify-content-between"><h6 class="mb-0 fw-semibold"><i class="fas fa-user-edit me-2 text-primary"></i>تعديل: {{ $doctor->user->name ?? 'طبيب' }}</h6><a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>رجوع</a></div><div class="card-body">
<form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">@csrf @method('PUT')
<h6 class="fw-semibold mb-3 text-muted">بيانات الحساب</h6>
<div class="row g-3 mb-4">
<div class="col-md-6"><label class="form-label fw-semibold">الاسم الكامل <span class="text-danger">*</span></label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $doctor->user->name) }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">البريد الإلكتروني <span class="text-danger">*</span></label><input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $doctor->user->email) }}" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">كلمة المرور الجديدة <small class="text-muted">(اتركها فارغة للاحتفاظ بالحالية)</small></label><input type="password" name="password" class="form-control @error('password') is-invalid @enderror">@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">تأكيد كلمة المرور الجديدة</label><input type="password" name="password_confirmation" class="form-control"></div>
</div>
<h6 class="fw-semibold mb-3 text-muted">البيانات المهنية</h6>
<div class="row g-3">
<div class="col-md-6"><label class="form-label fw-semibold">التخصص <span class="text-danger">*</span></label><input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization', $doctor->specialization) }}" required>@error('specialization')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">القسم</label><select name="department_id" class="form-select @error('department_id') is-invalid @enderror"><option value="">اختر القسم</option>@foreach($departments as $dept)<option value="{{ $dept->id }}" {{ old('department_id', $doctor->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>@endforeach</select>@error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-4"><label class="form-label fw-semibold">سنوات الخبرة</label><input type="number" name="experience_years" class="form-control @error('experience_years') is-invalid @enderror" value="{{ old('experience_years', $doctor->experience_years) }}" min="0" max="60">@error('experience_years')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-4"><label class="form-label fw-semibold">رسوم الاستشارة ($) <span class="text-danger">*</span></label><input type="number" step="0.01" name="consultation_fee" class="form-control @error('consultation_fee') is-invalid @enderror" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" min="0" required>@error('consultation_fee')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-4"><label class="form-label fw-semibold">الهاتف</label><input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $doctor->phone) }}">@error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><label class="form-label fw-semibold">المؤهلات</label><textarea name="qualifications" class="form-control" rows="2">{{ old('qualifications', $doctor->qualifications) }}</textarea></div>
<div class="col-12"><label class="form-label fw-semibold">نبذة / عن الطبيب</label><textarea name="bio" class="form-control" rows="3">{{ old('bio', $doctor->bio) }}</textarea></div>
<div class="col-12"><div class="form-check"><input type="hidden" name="is_available" value="0"><input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1" {{ $doctor->is_available ? 'checked' : '' }}><label class="form-check-label" for="is_available">متاح للمواعيد</label></div></div>
<div class="col-12 d-flex gap-2 mt-2"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>تحديث بيانات الطبيب</button><a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-secondary">إلغاء</a></div>
</div></form></div></div>
@endsection
