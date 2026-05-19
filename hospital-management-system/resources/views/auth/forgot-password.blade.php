<x-guest-layout>
    <h4 class="fw-bold text-center mb-1">Forgot Password?</h4>
    <p class="text-muted text-center small mb-4">Enter your email to receive a reset link</p>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label fw-semibold">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="fas fa-paper-plane me-2"></i>Send Reset Link
        </button>
    </form>

    <p class="text-center small text-muted mt-4 mb-0">
        <a href="{{ route('login') }}" class="text-primary text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i>Back to Login
        </a>
    </p>
</x-guest-layout>
