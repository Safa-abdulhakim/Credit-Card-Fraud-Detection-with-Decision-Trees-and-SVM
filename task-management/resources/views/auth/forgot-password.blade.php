@extends('layouts.guest')
@section('title', 'استعادة كلمة المرور')

@section('content')

<h5 class="fw-bold mb-1">نسيت كلمة المرور؟</h5>
<p class="text-muted small mb-4">أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور.</p>

@if(session('status'))
    <div class="alert alert-success mb-3" style="border-radius:0.6rem;">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-4">
        <label for="email" class="form-label">البريد الإلكتروني</label>
        <input type="email" id="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required autofocus
               placeholder="example@email.com">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-envelope me-2"></i>إرسال رابط الاستعادة
    </button>
</form>

<div class="text-center mt-4 pt-3 border-top">
    <a href="{{ route('login') }}" class="auth-link small">
        <i class="bi bi-arrow-right me-1"></i>العودة لتسجيل الدخول
    </a>
</div>

@endsection
