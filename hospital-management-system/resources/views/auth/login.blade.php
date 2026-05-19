<x-guest-layout>
    <h4 class="fw-bold text-center mb-1">Welcome Back</h4>
    <p class="text-muted text-center small mb-4">Sign in to your account</p>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="admin@hospital.com" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label fw-semibold mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="small text-primary text-decoration-none">Forgot password?</a>
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-4 d-flex align-items-center">
            <input type="checkbox" name="remember" id="remember_me" class="form-check-input me-2">
            <label for="remember_me" class="form-check-label small text-muted">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="fas fa-sign-in-alt me-2"></i>Sign In
        </button>
    </form>

    @if (Route::has('register'))
    <p class="text-center small text-muted mt-4 mb-0">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Register</a>
    </p>
    @endif

    <hr class="my-4">
    <div class="bg-light rounded p-3 small">
        <p class="fw-semibold mb-2 text-muted"><i class="fas fa-key me-1"></i>Demo Credentials (password: <code>password</code>):</p>
        <div class="row g-1">
            <div class="col-6"><span class="badge bg-danger w-100 text-start p-2">Admin<br><small class="opacity-75">admin@hospital.com</small></span></div>
            <div class="col-6"><span class="badge bg-primary w-100 text-start p-2">Doctor<br><small class="opacity-75">doctor1@hospital.com</small></span></div>
            <div class="col-6 mt-1"><span class="badge bg-success w-100 text-start p-2">Patient<br><small class="opacity-75">patient1@hospital.com</small></span></div>
            <div class="col-6 mt-1"><span class="badge bg-warning text-dark w-100 text-start p-2">Receptionist<br><small class="opacity-75">receptionist@hospital.com</small></span></div>
        </div>
    </div>
</x-guest-layout>
