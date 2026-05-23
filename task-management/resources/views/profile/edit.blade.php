@extends('layouts.app')
@section('title','الملف الشخصي')
@section('page-title','الملف الشخصي')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8">
    <div class="card form-card mb-4">
        <div class="card-header bg-white py-3 px-4">
            <h6 class="fw-bold mb-0"><i class="bi bi-person-circle text-primary me-2"></i>معلومات الحساب</h6>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PATCH')
                <div class="mb-3">
                    <label for="name" class="form-label">الاسم الكامل</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>حفظ التغييرات</button>
                @if(session('status')==='profile-updated')<span class="text-success ms-3 small"><i class="bi bi-check-circle me-1"></i>تم الحفظ!</span>@endif
            </form>
        </div>
    </div>
    <div class="card form-card mb-4">
        <div class="card-header bg-white py-3 px-4">
            <h6 class="fw-bold mb-0"><i class="bi bi-shield-lock text-warning me-2"></i>تغيير كلمة المرور</h6>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">كلمة المرور الحالية</label>
                    <input type="password" name="current_password" class="form-control @error('current_password','updatePassword') is-invalid @enderror">
                    @error('current_password','updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">كلمة المرور الجديدة</label>
                    <input type="password" name="password" class="form-control @error('password','updatePassword') is-invalid @enderror">
                    @error('password','updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <button type="submit" class="btn btn-warning text-white"><i class="bi bi-key me-2"></i>تغيير كلمة المرور</button>
                @if(session('status')==='password-updated')<span class="text-success ms-3 small"><i class="bi bi-check-circle me-1"></i>تم التغيير!</span>@endif
            </form>
        </div>
    </div>
</div></div>
@endsection
