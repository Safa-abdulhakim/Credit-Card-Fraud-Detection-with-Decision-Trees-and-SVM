<form method="post" action="{{ route('profile.update') }}">
    @csrf @method('patch')
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">الاسم</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12 d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save ms-2"></i>حفظ التغييرات</button>
            @if (session('status') === 'profile-updated')
                <span class="text-success small"><i class="fas fa-check ms-1"></i>تم الحفظ!</span>
            @endif
        </div>
    </div>
</form>
