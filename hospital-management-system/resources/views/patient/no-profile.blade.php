@extends('layouts.patient')
@section('title', 'لم يُعثر على ملف المريض')
@section('page-title', 'الملف الشخصي مطلوب')
@section('content')
<div class="text-center py-5">
    <i class="fas fa-user-times fa-5x text-muted mb-4"></i>
    <h4 class="fw-bold">لم يُعثر على ملف المريض</h4>
    <p class="text-muted">حسابك غير مرتبط بملف مريض بعد. يرجى التواصل مع موظف استقبال المستشفى.</p>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-secondary">تسجيل الخروج</button>
    </form>
</div>
@endsection
