@extends('layouts.app')
@section('title','لوحة التحكم')
@section('page-title','لوحة التحكم')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100"><div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="stat-icon bg-primary bg-opacity-10"><i class="bi bi-clipboard2-check text-primary"></i></div>
                <span class="badge bg-primary bg-opacity-10 text-primary">الكل</span>
            </div>
            <div class="stat-value text-dark">{{ $total }}</div>
            <div class="stat-label">إجمالي المهام</div>
        </div></div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100"><div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="stat-icon bg-success bg-opacity-10"><i class="bi bi-check2-circle text-success"></i></div>
                <span class="badge bg-success bg-opacity-10 text-success">مكتملة</span>
            </div>
            <div class="stat-value text-success">{{ $completed }}</div>
            <div class="stat-label">المهام المكتملة</div>
            @if($total > 0)
                <div class="progress mt-2" style="height:4px"><div class="progress-bar bg-success" style="width:{{ round(($completed/$total)*100) }}%"></div></div>
                <small class="text-muted">{{ round(($completed/$total)*100) }}% من الإجمالي</small>
            @endif
        </div></div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100"><div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="stat-icon bg-warning bg-opacity-10"><i class="bi bi-hourglass-split text-warning"></i></div>
                <span class="badge bg-warning bg-opacity-10 text-warning">معلقة</span>
            </div>
            <div class="stat-value text-warning">{{ $pending }}</div>
            <div class="stat-label">المهام المعلقة</div>
        </div></div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100"><div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="stat-icon bg-info bg-opacity-10"><i class="bi bi-arrow-repeat text-info"></i></div>
                <span class="badge bg-info bg-opacity-10 text-info">جارية</span>
            </div>
            <div class="stat-value text-info">{{ $inProgress }}</div>
            <div class="stat-label">قيد التنفيذ</div>
        </div></div>
    </div>
</div>
@if($overdueTasks > 0)
<div class="alert alert-danger d-flex align-items-center gap-2 mb-4" style="border-radius:.75rem;border:none">
    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
    <span>لديك <strong>{{ $overdueTasks }}</strong> مهمة متأخرة!</span>
    <a href="{{ route('tasks.index') }}" class="ms-auto btn btn-sm btn-danger">عرض المهام</a>
</div>
@endif
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-clock-history me-2 text-primary"></i>آخر المهام المضافة</span>
                <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل <i class="bi bi-arrow-left ms-1"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>المهمة</th><th>الأولوية</th><th>الحالة</th><th>التسليم</th><th></th></tr></thead>
                    <tbody>
                        @forelse($recentTasks as $task)
                        <tr>
                            <td><div class="fw-semibold small">{{ Str::limit($task->title,40) }}</div></td>
                            <td><span class="badge bg-{{ $task->priority_color }}">{{ $task->priority_label }}</span></td>
                            <td><span class="badge bg-{{ $task->status_color }}">{{ $task->status_label }}</span></td>
                            <td>
                                @if($task->due_date)
                                    <span class="{{ $task->isOverdue() ? 'text-danger fw-semibold' : 'text-muted' }} small">{{ $task->due_date->format('d/m/Y') }}</span>
                                @else <span class="text-muted small">—</span> @endif
                            </td>
                            <td><a href="{{ route('tasks.show',$task) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>لا توجد مهام. <a href="{{ route('tasks.create') }}">أضف مهمتك الأولى!</a>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card form-card mb-4"><div class="card-body">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightning-fill text-warning me-2"></i>إجراءات سريعة</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>إضافة مهمة</a>
                <a href="{{ route('tasks.index',['status'=>'pending']) }}" class="btn btn-outline-warning"><i class="bi bi-hourglass me-2"></i>المعلقة</a>
                <a href="{{ route('tasks.index',['priority'=>'high']) }}" class="btn btn-outline-danger"><i class="bi bi-fire me-2"></i>عالية الأولوية</a>
            </div>
        </div></div>
        <div class="card form-card"><div class="card-body">
            <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill text-primary me-2"></i>ملخص الأولويات</h6>
            @php $h=auth()->user()->tasks()->where('priority','high')->count(); $m=auth()->user()->tasks()->where('priority','medium')->count(); $l=auth()->user()->tasks()->where('priority','low')->count(); @endphp
            <div class="mb-3">
                <div class="d-flex justify-content-between small mb-1"><span class="text-danger fw-semibold">عالية</span><span>{{ $h }}</span></div>
                <div class="progress" style="height:6px"><div class="progress-bar bg-danger" style="width:{{ $total>0?round(($h/$total)*100):0 }}%"></div></div>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between small mb-1"><span class="text-primary fw-semibold">متوسطة</span><span>{{ $m }}</span></div>
                <div class="progress" style="height:6px"><div class="progress-bar bg-primary" style="width:{{ $total>0?round(($m/$total)*100):0 }}%"></div></div>
            </div>
            <div>
                <div class="d-flex justify-content-between small mb-1"><span class="text-secondary fw-semibold">منخفضة</span><span>{{ $l }}</span></div>
                <div class="progress" style="height:6px"><div class="progress-bar bg-secondary" style="width:{{ $total>0?round(($l/$total)*100):0 }}%"></div></div>
            </div>
        </div></div>
    </div>
</div>
@endsection
