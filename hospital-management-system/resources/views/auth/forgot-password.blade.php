<x-guest-layout>
    <h4 class="fw-bold text-center mb-1">نسيت كلمة المرور؟</h4>
    <p class="text-muted text-center small mb-4">أدخل بريدك الإلكتروني لتلقي رابط إعادة التعيين</p>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label fw-semibold">البريد الإلكتروني</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="fas fa-paper-plane ms-2"></i>إرسال رابط إعادة التعيين
        </button>
    </form>

    <p class="text-center small text-muted mt-4 mb-0">
        <a href="{{ route('login') }}" class="text-primary text-decoration-none">
            <i class="fas fa-arrow-right ms-1"></i>العودة إلى تسجيل الدخول
        </a>
    </p>
</x-guest-layout>
