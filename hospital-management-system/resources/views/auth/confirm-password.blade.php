<x-guest-layout>
    <h4 class="fw-bold text-center mb-1">تأكيد كلمة المرور</h4>
    <p class="text-muted text-center small mb-4">يرجى تأكيد كلمة المرور قبل المتابعة.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label fw-semibold">كلمة المرور</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="أدخل كلمة المرور" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="fas fa-shield-alt ms-2"></i>تأكيد
        </button>
    </form>
</x-guest-layout>
