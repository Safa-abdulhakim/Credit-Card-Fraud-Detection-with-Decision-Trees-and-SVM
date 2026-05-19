<x-guest-layout>
    <div class="text-center mb-4">
        <i class="fas fa-envelope-open-text fa-3x text-primary mb-3"></i>
        <h4 class="fw-bold">Verify Your Email</h4>
        <p class="text-muted small">Thanks for signing up! Please verify your email by clicking the link we sent you.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success small">
            <i class="fas fa-check-circle me-2"></i>A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="d-flex flex-column gap-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-paper-plane me-2"></i>Resend Verification Email
            </button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
        </form>
    </div>
</x-guest-layout>
