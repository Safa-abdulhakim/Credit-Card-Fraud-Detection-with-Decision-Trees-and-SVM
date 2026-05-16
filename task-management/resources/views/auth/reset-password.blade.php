@extends('layouts.guest')
@section('title', 'إعادة تعيين كلمة المرور')

@section('content')

<h5 class="fw-bold mb-1">إعادة تعيين كلمة المرور</h5>
<p class="text-muted small mb-4">أدخل كلمة المرور الجديدة.</p>

<form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="mb-3">
        <label for="email" class="form-label">البريد الإلكتروني</label>
        <input type="email" id="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $request->email) }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">كلمة المرور الجديدة</label>
        <input type="password" id="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               required placeholder="8 أحرف على الأقل">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="form-control" required placeholder="أعد إدخال كلمة المرور">
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-key me-2"></i>تعيين كلمة المرور
    </button>
</form>

@endsection
