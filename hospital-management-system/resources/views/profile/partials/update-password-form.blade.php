<form method="post" action="{{ route('password.update') }}">
    @csrf @method('put')
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label fw-semibold">كلمة المرور الحالية</label>
            <input type="password" name="current_password" class="form-control @error('current_password','updatePassword') is-invalid @enderror">
            @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">كلمة المرور الجديدة</label>
            <input type="password" name="password" class="form-control @error('password','updatePassword') is-invalid @enderror">
            @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="col-12 d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-key ms-2"></i>تحديث كلمة المرور</button>
            @if (session('status') === 'password-updated')
                <span class="text-success small"><i class="fas fa-check ms-1"></i>تم تحديث كلمة المرور!</span>
            @endif
        </div>
    </div>
</form>
