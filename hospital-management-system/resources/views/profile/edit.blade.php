<x-app-layout>
    <x-slot name="header">
        <h5 class="fw-bold mb-0"><i class="fas fa-user-cog ms-2"></i>إعدادات الملف الشخصي</h5>
    </x-slot>

    <div class="row justify-content-center g-4">
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0 fw-semibold">تحديث معلومات الملف الشخصي</h6></div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0 fw-semibold">تغيير كلمة المرور</h6></div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="card border-danger">
                <div class="card-header bg-danger bg-opacity-10"><h6 class="mb-0 fw-semibold text-danger">حذف الحساب</h6></div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
