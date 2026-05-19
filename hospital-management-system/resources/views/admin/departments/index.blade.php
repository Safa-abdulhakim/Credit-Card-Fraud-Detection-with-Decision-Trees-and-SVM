@extends('layouts.admin')
@section('title', 'الأقسام')
@section('page-title', 'الأقسام')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item active">الأقسام</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.departments.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>إضافة قسم</a>
@endsection
@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>اسم القسم</th>
                        <th>الوصف</th>
                        <th>رئيس القسم</th>
                        <th>الأطباء</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $dept)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $dept->name }}</strong></td>
                        <td>{{ Str::limit($dept->description, 50) ?? '-' }}</td>
                        <td>{{ $dept->head_doctor ?? '-' }}</td>
                        <td><span class="badge bg-primary">{{ $dept->doctors_count }}</span></td>
                        <td>
                            <span class="badge bg-{{ $dept->is_active ? 'success' : 'danger' }}">
                                {{ $dept->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.departments.show', $dept) }}" class="btn btn-outline-info" title="عرض"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.departments.edit', $dept) }}" class="btn btn-outline-primary" title="تعديل"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف هذا القسم؟')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger" title="حذف"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">لا توجد أقسام</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($departments->hasPages())
    <div class="card-footer">{{ $departments->links() }}</div>
    @endif
</div>
@endsection
