@extends('layouts.app')
@section('title',$task->title)
@section('page-title','تفاصيل المهمة')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-right me-1"></i>رجوع</a>
        <div class="d-flex gap-2">
            <a href="{{ route('tasks.edit',$task) }}" class="btn btn-sm btn-warning text-white"><i class="bi bi-pencil me-1"></i>تعديل</a>
            <form method="POST" action="{{ route('tasks.destroy',$task) }}">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger" data-confirm-delete="هل أنت متأكد من حذف مهمة «{{ $task->title }}»؟ لا يمكن التراجع عن هذا الإجراء."><i class="bi bi-trash me-1"></i>حذف</button>
            </form>
        </div>
    </div>
    <div class="card form-card">
        <div class="card-header bg-white py-4 px-4">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <h4 class="fw-bold mb-2">{{ $task->title }}</h4>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-{{ $task->status_color }} fs-6">{{ $task->status_label }}</span>
                        <span class="badge bg-{{ $task->priority_color }} fs-6"><i class="bi bi-flag me-1"></i>{{ $task->priority_label }}</span>
                        @if($task->isOverdue())<span class="badge bg-danger fs-6"><i class="bi bi-exclamation-triangle me-1"></i>متأخرة</span>@endif
                    </div>
                </div>
                <div class="text-muted small text-end">
                    <div><i class="bi bi-calendar-plus me-1"></i>{{ $task->created_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="mb-4">
                <h6 class="text-muted fw-semibold mb-2"><i class="bi bi-file-text me-2"></i>الوصف</h6>
                @if($task->description)
                    <p class="mb-0" style="line-height:1.8">{{ $task->description }}</p>
                @else
                    <p class="text-muted fst-italic mb-0">لا يوجد وصف لهذه المهمة.</p>
                @endif
            </div>
            <hr>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="bg-light rounded-3 p-3 text-center">
                        <div class="text-muted small mb-1">تاريخ التسليم</div>
                        @if($task->due_date)
                            <div class="fw-bold {{ $task->isOverdue()?'text-danger':'text-dark' }}">{{ $task->due_date->format('d/m/Y') }}</div>
                            <div class="text-muted small">{{ $task->due_date->diffForHumans() }}</div>
                        @else <div class="text-muted">غير محدد</div> @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light rounded-3 p-3 text-center">
                        <div class="text-muted small mb-1">تاريخ الإنشاء</div>
                        <div class="fw-bold">{{ $task->created_at->format('d/m/Y') }}</div>
                        <div class="text-muted small">{{ $task->created_at->format('H:i') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light rounded-3 p-3 text-center">
                        <div class="text-muted small mb-1">صاحب المهمة</div>
                        <div class="fw-bold">{{ $task->user->name }}</div>
                        <div class="text-muted small">{{ $task->user->email }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white py-3 px-4 d-flex gap-2">
            <a href="{{ route('tasks.edit',$task) }}" class="btn btn-primary"><i class="bi bi-pencil me-2"></i>تعديل المهمة</a>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">العودة للقائمة</a>
        </div>
    </div>
</div></div>
@endsection
