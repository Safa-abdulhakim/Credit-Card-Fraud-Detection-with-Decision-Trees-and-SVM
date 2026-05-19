@extends('layouts.admin')
@section('title', 'إضافة مريض')
@section('page-title', 'إضافة مريض جديد')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.patients.index') }}">المرضى</a></li>
    <li class="breadcrumb-item active">إضافة</li>
@endsection
@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-user-plus me-2 text-primary"></i>معلومات المريض</h6></div>
    <div class="card-body">
        <form action="{{ route('admin.patients.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">الاسم الكامل <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="أدخل الاسم الكامل للمريض" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">تاريخ الميلاد <span class="text-danger">*</span></label>
                    <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d') }}" required>
                    @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">الجنس <span class="text-danger">*</span></label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                        <option value="">اختر الجنس</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>أخرى</option>
                    </select>
                    @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">الهاتف <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+1 234 567 8900" required>
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">فصيلة الدم</label>
                    <select name="blood_group" class="form-select @error('blood_group') is-invalid @enderror">
                        <option value="">اختر فصيلة الدم</option>
                        @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                            <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                    @error('blood_group')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="patient@example.com">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">جهة الاتصال في الطوارئ</label>
                    <input type="text" name="emergency_contact" class="form-control @error('emergency_contact') is-invalid @enderror" value="{{ old('emergency_contact') }}" placeholder="الاسم - رقم الهاتف">
                    @error('emergency_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">العنوان</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="الشارع، المدينة، الولاية">
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">الحساسية</label>
                    <textarea name="allergies" class="form-control @error('allergies') is-invalid @enderror" rows="3" placeholder="اذكر أي حساسية معروفة (مثل: البنسلين، المكسرات)...">{{ old('allergies') }}</textarea>
                    @error('allergies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">التاريخ المرضي</label>
                    <textarea name="medical_history" class="form-control @error('medical_history') is-invalid @enderror" rows="3" placeholder="الحالات السابقة، العمليات الجراحية، الأمراض المزمنة...">{{ old('medical_history') }}</textarea>
                    @error('medical_history')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>حفظ المريض</button>
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
