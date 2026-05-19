@extends('layouts.admin')
@section('title', 'التقارير')
@section('page-title', 'التقارير')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item active">التقارير</li>
@endsection
@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 text-center">
            <div class="card-body py-4">
                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                <h5 class="fw-semibold mb-2">تقارير المرضى</h5>
                <p class="text-muted small mb-3">عرض وتصدير بيانات المرضى المسجلين</p>
                <a href="{{ route('admin.reports.patients') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-chart-bar me-1"></i>عرض التقرير
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center">
            <div class="card-body py-4">
                <i class="fas fa-calendar-check fa-3x text-success mb-3"></i>
                <h5 class="fw-semibold mb-2">تقارير المواعيد</h5>
                <p class="text-muted small mb-3">عرض وتصدير بيانات المواعيد</p>
                <a href="{{ route('admin.reports.appointments') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-chart-bar me-1"></i>عرض التقرير
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center">
            <div class="card-body py-4">
                <i class="fas fa-dollar-sign fa-3x text-warning mb-3"></i>
                <h5 class="fw-semibold mb-2">تقارير الإيرادات</h5>
                <p class="text-muted small mb-3">عرض وتصدير بيانات الإيرادات والمدفوعات</p>
                <a href="{{ route('admin.reports.revenue') }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-chart-bar me-1"></i>عرض التقرير
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
