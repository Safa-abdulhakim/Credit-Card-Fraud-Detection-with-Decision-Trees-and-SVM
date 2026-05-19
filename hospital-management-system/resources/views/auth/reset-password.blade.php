<x-guest-layout>
    <h4 class="fw-bold text-center mb-1">إعادة تعيين كلمة المرور</h4>
    <p class="text-muted text-center small mb-4">أدخل كلمة المرور الجديدة</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label class="form-label fw-semibold">البريد الإلكتروني</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $request->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">كلمة المرور الجديدة</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="8 أحرف على الأقل" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">تأكيد كلمة المرور الجديدة</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="fas fa-key ms-2"></i>إعادة تعيين كلمة المرور
        </button>
    </form>
</x-guest-layout>
