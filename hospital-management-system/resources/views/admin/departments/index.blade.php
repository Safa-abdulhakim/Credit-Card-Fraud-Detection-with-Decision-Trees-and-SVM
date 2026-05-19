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
<div class="card"><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>#</th><th>اسم القسم</th><th>الوصف</th><th>عدد الأطباء</th><th>الحالة</th><th>الإجراءات</th></tr></thead><tbody>@forelse($departments as $dept)<tr><td>{{ $loop->iteration }}</td><td><div class="fw-semibold">{{ $dept->name }}</div></td><td><small class="text-muted">{{ Str::limit($dept->description, 60) ?? '-' }}</small></td><td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $dept->doctors_count }} طبيب</span></td><td>@if($dept->is_active)<span class="badge bg-success">نشط</span>@else<span class="badge bg-secondary">غير نشط</span>@endif</td><td><div class="btn-group btn-group-sm"><a href="{{ route('admin.departments.show', $dept) }}" class="btn btn-outline-info" title="عرض"><i class="fas fa-eye"></i></a><a href="{{ route('admin.departments.edit', $dept) }}" class="btn btn-outline-primary" title="تعديل"><i class="fas fa-edit"></i></a><form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذا القسم؟')">@csrf @method('DELETE')<button type="submit" class="btn btn-outline-danger" title="حذف"><i class="fas fa-trash"></i></button></form></div></td></tr>@empty<tr><td colspan="6" class="text-center text-muted py-5"><i class="fas fa-building fa-2x mb-2 d-block opacity-25"></i>لا توجد أقسام. <a href="{{ route('admin.departments.create') }}">إضافة أول قسم</a></td></tr>@endforelse</tbody></table></div></div>@if(method_exists($departments,'hasPages') && $departments->hasPages())<div class="card-footer">{{ $departments->links() }}</div>@endif</div>
@endsection
