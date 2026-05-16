@extends('layouts.app')

@section('title', 'الملف الشخصي')
@section('page-title', 'الملف الشخصي')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Update Profile Info --}}
        <div class="card form-card mb-4">
            <div class="card-header bg-white py-3 px-4">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-person-circle text-primary me-2"></i>معلومات الحساب
                </h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم الكامل</label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>حفظ التغييرات
                    </button>

                    @if(session('status') === 'profile-updated')
                        <span class="text-success ms-3 small">
                            <i class="bi bi-check-circle me-1"></i>تم الحفظ بنجاح!
                        </span>
                    @endif
                </form>
            </div>
        </div>

        {{-- Update Password --}}
        <div class="card form-card mb-4">
            <div class="card-header bg-white py-3 px-4">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-shield-lock text-warning me-2"></i>تغيير كلمة المرور
                </h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                        <input type="password" id="current_password" name="current_password"
                               class="form-control @error('current_password','updatePassword') is-invalid @enderror">
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">كلمة المرور الجديدة</label>
                        <input type="password" id="new_password" name="password"
                               class="form-control @error('password','updatePassword') is-invalid @enderror">
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control">
                    </div>

                    <button type="submit" class="btn btn-warning text-white">
                        <i class="bi bi-key me-2"></i>تغيير كلمة المرور
                    </button>

                    @if(session('status') === 'password-updated')
                        <span class="text-success ms-3 small">
                            <i class="bi bi-check-circle me-1"></i>تم التغيير بنجاح!
                        </span>
                    @endif
                </form>
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="card form-card border border-danger border-opacity-25">
            <div class="card-header bg-white py-3 px-4">
                <h6 class="fw-bold mb-0 text-danger">
                    <i class="bi bi-trash3 me-2"></i>حذف الحساب
                </h6>
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-4">
                    بمجرد حذف حسابك، سيتم حذف جميع بياناتك ومهامك بشكل نهائي. تأكد من تنزيل أي بيانات مهمة قبل الحذف.
                </p>
                <button type="button" class="btn btn-outline-danger"
                        data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="bi bi-trash me-2"></i>حذف الحساب نهائياً
                </button>
            </div>
        </div>

    </div>
</div>

{{-- Delete Account Modal --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:1rem;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>تأكيد الحذف
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">هل أنت متأكد أنك تريد حذف حسابك؟ هذا الإجراء لا يمكن التراجع عنه.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">أدخل كلمة المرور للتأكيد</label>
                        <input type="password" id="delete_password" name="password"
                               class="form-control @error('password','userDeletion') is-invalid @enderror"
                               placeholder="كلمة المرور">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" form="deleteForm" class="btn btn-danger">
                    <i class="bi bi-trash me-2"></i>حذف الحساب
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
