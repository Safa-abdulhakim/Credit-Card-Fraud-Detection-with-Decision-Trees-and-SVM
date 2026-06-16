@extends('layouts.guest')
@section('title','إنشاء حساب')
@section('content')
<h5 class="fw-bold mb-1">إنشاء حساب جديد</h5>
<p class="text-muted small mb-4">أنشئ حسابك وابدأ في إدارة مهامك</p>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">الاسم الكامل</label>
        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus placeholder="أدخل اسمك الكامل">
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">البريد الإلكتروني</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="example@email.com">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">كلمة المرور</label>
        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="8 أحرف على الأقل">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="أعد إدخال كلمة المرور">
    </div>
    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-person-plus me-2"></i>إنشاء الحساب</button>
</form>
<div class="text-center mt-4 pt-3 border-top">
    <span class="text-muted small">لديك حساب؟</span>
    <a href="{{ route('login') }}" class="auth-link small ms-1">تسجيل الدخول</a>
</div>
@endsection
