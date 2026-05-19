@extends('layouts.admin')
@section('title', 'السجلات الطبية')
@section('page-title', 'السجلات الطبية')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">السجلات الطبية</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.medical-records.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>إضافة سجل طبي
    </a>
@endsection
@section('content')
<!-- Filters -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="البحث عن مريض أو تشخيص..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="doctor_id" class="form-select form-select-sm">
                    <option value="">جميع الأطباء</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>{{ $doc->user->name ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="من تاريخ">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i> تصفية</button>
                <a href="{{ route('admin.medical-records.index') }}" class="btn btn-secondary btn-sm">إعادة تعيين</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>المريض</th>
                        <th>الطبيب</th>
                        <th>التشخيص</th>
                        <th>تاريخ الزيارة</th>
                        <th>المتابعة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                    <tr>
                        <td>{{ $records->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-semibold">{{ $record->patient->name }}</div>
                            <small class="text-muted">{{ ucfirst($record->patient->gender) }}, {{ $record->patient->age }} yrs</small>
                        </td>
                        <td>
                            <div class="fw-semibold small">{{ $record->doctor->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $record->doctor->specialization ?? '' }}</small>
                        </td>
                        <td><small>{{ Str::limit($record->diagnosis, 60) }}</small></td>
                        <td><small>{{ $record->record_date->format('M d, Y') }}</small></td>
                        <td>
                            @if($record->notes)
                                <small class="text-muted">{{ Str::limit($record->notes, 40) }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.medical-records.show', $record) }}" class="btn btn-outline-info" title="عرض"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.medical-records.edit', $record) }}" class="btn btn-outline-primary" title="تعديل"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.medical-records.destroy', $record) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذا السجل الطبي؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="حذف"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-file-medical fa-2x mb-2 d-block opacity-25"></i>
                            لا توجد سجلات طبية.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($records->hasPages())
    <div class="card-footer">{{ $records->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
