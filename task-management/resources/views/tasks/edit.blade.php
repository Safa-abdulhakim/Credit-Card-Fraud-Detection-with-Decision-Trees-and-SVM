@extends('layouts.app')
@section('title','تعديل المهمة')
@section('page-title','تعديل المهمة')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8">
    <div class="mb-4"><a href="{{ route('tasks.show',$task) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-right me-1"></i>رجوع</a></div>
    <div class="card form-card">
        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-bold"><i class="bi bi-pencil text-warning me-2"></i>تعديل المهمة</h6>
            <span class="badge bg-{{ $task->status_color }}">{{ $task->status_label }}</span>
        </div>
        <div class="card-body p-4">
            {{-- ✅ form التعديل منفصل --}}
            <form id="update-form" method="POST" action="{{ route('tasks.update',$task) }}" novalidate>
                @csrf @method('PUT')
                <div class="mb-4">
                    <label for="title" class="form-label">عنوان المهمة <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title',$task->title) }}" autofocus>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description',$task->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach(\App\Models\Task::STATUSES as $key=>$label)
                                <option value="{{ $key }}" {{ old('status',$task->status)===$key?'selected':'' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="priority" class="form-label">الأولوية <span class="text-danger">*</span></label>
                        <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror">
                            @foreach(\App\Models\Task::PRIORITIES as $key=>$label)
                                <option value="{{ $key }}" {{ old('priority',$task->priority)===$key?'selected':'' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="due_date" class="form-label">تاريخ التسليم</label>
                        <input type="date" id="due_date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date',$task->due_date?->format('Y-m-d')) }}">
                        @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </form>
            {{-- ✅ الأزرار خارج form التعديل --}}
            <div class="d-flex gap-3 pt-2 border-top">
                <button type="submit" form="update-form" class="btn btn-warning px-4 text-white">
                    <i class="bi bi-save me-2"></i>حفظ التعديلات
                </button>
                <a href="{{ route('tasks.show',$task) }}" class="btn btn-outline-secondary px-4">إلغاء</a>
                {{-- ✅ form الحذف منفصل تماماً --}}
                <form method="POST" action="{{ route('tasks.destroy',$task) }}" class="ms-auto" onsubmit="return confirm('هل أنت متأكد من حذف هذه المهمة؟')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger px-4"><i class="bi bi-trash me-2"></i>حذف</button>
                </form>
            </div>
        </div>
    </div>
</div></div>
@endsection
