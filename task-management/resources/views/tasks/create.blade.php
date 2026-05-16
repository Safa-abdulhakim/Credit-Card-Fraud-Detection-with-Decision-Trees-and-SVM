@extends('layouts.app')

@section('title', 'إضافة مهمة')
@section('page-title', 'إضافة مهمة جديدة')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="bi bi-arrow-right me-1"></i>رجوع
            </a>
        </div>

        <div class="card form-card">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-plus-circle text-primary me-2"></i>بيانات المهمة الجديدة
                </h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('tasks.store') }}" novalidate>
                    @csrf

                    {{-- Title --}}
                    <div class="mb-4">
                        <label for="title" class="form-label">
                            عنوان المهمة <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="title" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}"
                               placeholder="أدخل عنوان المهمة..."
                               autofocus>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea id="description" name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="أدخل وصف المهمة (اختياري)...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        {{-- Status --}}
                        <div class="col-md-4">
                            <label for="status" class="form-label">
                                الحالة <span class="text-danger">*</span>
                            </label>
                            <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                <option value="">اختر الحالة...</option>
                                @foreach(\App\Models\Task::STATUSES as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('status', 'pending') === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Priority --}}
                        <div class="col-md-4">
                            <label for="priority" class="form-label">
                                الأولوية <span class="text-danger">*</span>
                            </label>
                            <select id="priority" name="priority"
                                    class="form-select @error('priority') is-invalid @enderror">
                                <option value="">اختر الأولوية...</option>
                                @foreach(\App\Models\Task::PRIORITIES as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('priority', 'medium') === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Due Date --}}
                        <div class="col-md-4">
                            <label for="due_date" class="form-label">تاريخ التسليم</label>
                            <input type="date" id="due_date" name="due_date"
                                   class="form-control @error('due_date') is-invalid @enderror"
                                   value="{{ old('due_date') }}"
                                   min="{{ date('Y-m-d') }}">
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3 pt-2 border-top">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-2"></i>حفظ المهمة
                        </button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-4">
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
