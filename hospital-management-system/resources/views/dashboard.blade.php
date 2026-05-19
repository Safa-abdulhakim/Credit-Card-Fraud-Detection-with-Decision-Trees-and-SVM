<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-5">
            {{ __('لوحة التحكم') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    {{ __('تم تسجيل الدخول بنجاح!') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
