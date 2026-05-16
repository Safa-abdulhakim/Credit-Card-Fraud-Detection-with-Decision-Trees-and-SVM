@extends('layouts.guest')
@section('title', 'تسجيل الدخول')

@section('content')

@if(session('status'))
    <div class="alert alert-success mb-3" style="border-radius:0.6rem;">{{ session('status') }}</div>
@endif

<h5 class="fw-bold mb-1">مرحباً بك!</h5>
<p class="text-muted small mb-4">سجّل دخولك للوصول إلى لوحة التحكم</p>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">البريد الإلكتروني</label>
        <input type="email" id="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required autofocus
               placeholder="example@email.com">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="password" class="form-label mb-0">كلمة المرور</label>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link small">نسيت كلمة المرور؟</a>
            @endif
        </div>
        <input type="password" id="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               required placeholder="••••••••">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label text-muted small" for="remember">تذكرني</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-box-arrow-in-right me-2"></i>تسجيل الدخول
    </button>
</form>

@if(Route::has('register'))
    <div class="text-center mt-4 pt-3 border-top">
        <span class="text-muted small">ليس لديك حساب؟</span>
        <a href="{{ route('register') }}" class="auth-link small ms-1">إنشاء حساب جديد</a>
    </div>
@endif

@endsection
