<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
        <i class="fas fa-hospital-alt me-2"></i>MediCare HMS
    </a>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="text-white-50 small">{{ auth()->user()->name }}</span>
        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-light">
            <i class="fas fa-user me-1"></i>الملف الشخصي
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-sign-out-alt me-1"></i>تسجيل الخروج
            </button>
        </form>
    </div>
</nav>
