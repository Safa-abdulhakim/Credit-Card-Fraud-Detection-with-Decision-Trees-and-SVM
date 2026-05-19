<x-guest-layout>
    <div class="text-center mb-4">
        <i class="fas fa-envelope-open-text fa-3x text-primary mb-3"></i>
        <h4 class="fw-bold">تحقق من بريدك الإلكتروني</h4>
        <p class="text-muted small">شكراً لتسجيلك! يرجى التحقق من بريدك الإلكتروني بالنقر على الرابط الذي أرسلناه إليك.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success small">
            <i class="fas fa-check-circle ms-2"></i>تم إرسال رابط تحقق جديد إلى عنوان بريدك الإلكتروني.
        </div>
    @endif

    <div class="d-flex flex-column gap-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-paper-plane ms-2"></i>إعادة إرسال بريد التحقق
            </button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100">
                <i class="fas fa-sign-out-alt ms-2"></i>تسجيل الخروج
            </button>
        </form>
    </div>
</x-guest-layout>
