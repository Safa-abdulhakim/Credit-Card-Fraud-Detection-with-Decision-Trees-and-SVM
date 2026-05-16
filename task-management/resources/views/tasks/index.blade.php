@extends('layouts.app')

@section('title', 'المهام')
@section('page-title', 'جميع المهام')

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <p class="text-muted mb-0">إجمالي {{ $tasks->total() }} مهمة</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>إضافة مهمة
    </a>
</div>

{{-- Filters --}}
<div class="card form-card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('tasks.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small mb-1">بحث بعنوان المهمة</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0"
                           placeholder="ابحث عن مهمة..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">الحالة</label>
                <select name="status" class="form-select">
                    <option value="">جميع الحالات</option>
                    @foreach(\App\Models\Task::STATUSES as $key => $label)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">الأولوية</label>
                <select name="priority" class="form-select">
                    <option value="">جميع الأولويات</option>
                    @foreach(\App\Models\Task::PRIORITIES as $key => $label)
                        <option value="{{ $key }}" {{ request('priority') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-funnel me-1"></i>فلترة
                </button>
                @if(request()->hasAny(['search','status','priority']))
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Active Filters Badges --}}
@if(request()->hasAny(['search','status','priority']))
<div class="mb-3 d-flex gap-2 flex-wrap">
    @if(request('search'))
        <span class="badge bg-secondary py-2 px-3">
            بحث: "{{ request('search') }}"
        </span>
    @endif
    @if(request('status'))
        <span class="badge bg-info py-2 px-3">
            الحالة: {{ \App\Models\Task::STATUSES[request('status')] ?? '' }}
        </span>
    @endif
    @if(request('priority'))
        <span class="badge bg-warning text-dark py-2 px-3">
            الأولوية: {{ \App\Models\Task::PRIORITIES[request('priority')] ?? '' }}
        </span>
    @endif
</div>
@endif

{{-- Tasks Table --}}
<div class="card table-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:35%">المهمة</th>
                    <th>الأولوية</th>
                    <th>الحالة</th>
                    <th>تاريخ التسليم</th>
                    <th>تاريخ الإنشاء</th>
                    <th class="text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $task->title }}</div>
                        @if($task->description)
                            <div class="text-muted small mt-1">
                                {{ Str::limit($task->description, 60) }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $task->priority_color }}">
                            {{ $task->priority_label }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $task->status_color }}">
                            {{ $task->status_label }}
                        </span>
                    </td>
                    <td>
                        @if($task->due_date)
                            <span class="{{ $task->isOverdue() ? 'text-danger fw-semibold' : 'text-muted' }} small">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $task->due_date->format('d/m/Y') }}
                                @if($task->isOverdue())
                                    <br><span class="badge bg-danger" style="font-size:0.65rem;">متأخرة</span>
                                @endif
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="text-muted small">
                            {{ $task->created_at->format('d/m/Y') }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('tasks.show', $task) }}"
                               class="btn btn-sm btn-outline-primary"
                               title="عرض">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('tasks.edit', $task) }}"
                               class="btn btn-sm btn-outline-secondary"
                               title="تعديل">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذه المهمة؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                        <h6 class="fw-semibold">لا توجد مهام</h6>
                        <p class="small mb-3">
                            @if(request()->hasAny(['search','status','priority']))
                                لا توجد مهام تطابق معايير البحث.
                            @else
                                لم تقم بإضافة أي مهام بعد.
                            @endif
                        </p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-2"></i>إضافة مهمة الآن
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tasks->hasPages())
    <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center py-3">
        <div class="text-muted small">
            عرض {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} من {{ $tasks->total() }} مهمة
        </div>
        <div>
            {{ $tasks->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>

@endsection
