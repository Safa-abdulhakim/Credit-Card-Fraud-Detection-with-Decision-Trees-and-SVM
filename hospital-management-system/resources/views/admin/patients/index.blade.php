@extends('layouts.admin')
@section('title', 'المرضى')
@section('page-title', 'المرضى')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item active">المرضى</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>إضافة مريض
    </a>
@endsection
@section('content')
<!-- Search/Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="البحث عن مرضى..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="gender" class="form-select form-select-sm">
                    <option value="">جميع الجنسيات</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                    <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>أخرى</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="blood_group" class="form-select form-select-sm">
                    <option value="">جميع فصائل الدم</option>
                    @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                        <option value="{{ $bg }}" {{ request('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i> تصفية</button>
                <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary btn-sm">إعادة تعيين</a>
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
                        <th>مريض</th>
                        <th>العمر / الجنس</th>
                        <th>الهاتف</th>
                        <th>فصيلة الدم</th>
                        <th>تاريخ التسجيل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td>{{ $patients->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-{{ $patient->gender == 'male' ? 'primary' : 'danger' }} bg-opacity-10 text-{{ $patient->gender == 'male' ? 'primary' : 'danger' }} rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;font-size:0.8rem;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($patient->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $patient->name }}</div>
                                    <small class="text-muted">{{ $patient->email ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $patient->age }} سنة / {{ ucfirst($patient->gender) }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>
                            @if($patient->blood_group)
                                <span class="badge bg-danger bg-opacity-10 text-danger">{{ $patient->blood_group }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td><small>{{ $patient->created_at->format('M d, Y') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-outline-info" title="عرض"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-outline-primary" title="تعديل"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذا المريض؟ لا يمكن التراجع عن هذا الإجراء.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="حذف"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-procedures fa-2x mb-2 d-block opacity-25"></i>
                            لا يوجد مرضى.
                            <a href="{{ route('admin.patients.create') }}">إضافة أول مريض</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($patients->hasPages())
    <div class="card-footer">
        {{ $patients->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
