<x-guest-layout>
    <h4 class="fw-bold text-center mb-1">إنشاء حساب</h4>
    <p class="text-muted text-center small mb-4">التسجيل كمريض جديد</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">الاسم الكامل</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="الاسم الكامل" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">البريد الإلكتروني</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="you@example.com" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">كلمة المرور</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="8 أحرف على الأقل" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="password_confirmation" class="form-control"
                    placeholder="أعد إدخال كلمة المرور" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="fas fa-user-plus ms-2"></i>تسجيل
        </button>
    </form>

    <p class="text-center small text-muted mt-4 mb-0">
        لديك حساب بالفعل؟
        <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">تسجيل الدخول</a>
    </p>
</x-guest-layout>
