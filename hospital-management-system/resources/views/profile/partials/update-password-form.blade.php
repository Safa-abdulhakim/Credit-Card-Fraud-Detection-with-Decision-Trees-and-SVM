<form method="post" action="{{ route('password.update') }}">
    @csrf @method('put')
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Current Password</label>
            <input type="password" name="current_password" class="form-control @error('current_password','updatePassword') is-invalid @enderror">
            @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">New Password</label>
            <input type="password" name="password" class="form-control @error('password','updatePassword') is-invalid @enderror">
            @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="col-12 d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-key me-2"></i>Update Password</button>
            @if (session('status') === 'password-updated')
                <span class="text-success small"><i class="fas fa-check me-1"></i>Password updated!</span>
            @endif
        </div>
    </div>
</form>
