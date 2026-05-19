@extends('layouts.admin')
@section('title', 'الأطباء')
@section('page-title', 'الأطباء')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item active">الأطباء</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>إضافة طبيب</a>
@endsection
@section('content')
<!-- Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="البحث عن أطباء..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="department" class="form-select form-select-sm">
                    <option value="">جميع الأقسام</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i> تصفية</button>
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary btn-sm">إعادة تعيين</a>
            </div>
        </form>
    </div>
</div>
<div class="row g-3">
    @forelse($doctors as $doctor)
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card h-100">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    @if($doctor->photo)
                        <img src="{{ asset('storage/' . $doctor->photo) }}" class="rounded-circle" style="width:80px;height:80px;object-fit:cover;" alt="طبيب">
                    @else
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:80px;height:80px;font-size:1.8rem;font-weight:700;">
                            {{ strtoupper(substr($doctor->user->name ?? 'D', 0, 2)) }}
                        </div>
                    @endif
                </div>
                <h6 class="fw-bold mb-1">{{ $doctor->user->name ?? 'N/A' }}</h6>
                <p class="text-primary small mb-1">{{ $doctor->specialization }}</p>
                <p class="text-muted small mb-2">{{ $doctor->department->name ?? 'N/A' }}</p>
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge bg-light text-dark"><i class="fas fa-clock me-1"></i>{{ $doctor->experience_years }} سنة</span>
                    <span class="badge bg-light text-dark"><i class="fas fa-dollar-sign me-1"></i>${{ number_format($doctor->consultation_fee, 2) }}</span>
                </div>
                <span class="badge bg-{{ $doctor->is_available ? 'success' : 'secondary' }} mb-3">
                    {{ $doctor->is_available ? 'متاح' : 'غير متاح' }}
                </span>
                <div class="d-flex gap-1 justify-content-center">
                    <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف هذا الطبيب؟')">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12"><div class="card"><div class="card-body text-center text-muted py-5">لا يوجد أطباء</div></div></div>
    @endforelse
</div>
@if($doctors->hasPages())
<div class="mt-3">{{ $doctors->links() }}</div>
@endif
@endsection
