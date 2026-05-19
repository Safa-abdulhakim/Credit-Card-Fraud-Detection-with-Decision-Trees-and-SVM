@extends('layouts.admin')
@section('title', 'تعديل الفاتورة')
@section('page-title', 'تعديل الفاتورة')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">الفواتير</a></li>
    <li class="breadcrumb-item active">تعديل</li>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i>تفاصيل الفاتورة</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST" id="invoiceForm">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">المريض <span class="text-danger">*</span></label>
                            <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                                <option value="">اختر المريض</option>
                                @foreach($patients as $p)
                                    <option value="{{ $p->id }}" {{ old('patient_id', $invoice->patient_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">الموعد (اختياري)</label>
                            <select name="appointment_id" class="form-select">
                                <option value="">بدون موعد</option>
                                @foreach($appointments as $a)
                                    <option value="{{ $a->id }}" {{ old('appointment_id', $invoice->appointment_id) == $a->id ? 'selected' : '' }}>
                                        {{ $a->patient->name ?? '' }} - {{ $a->appointment_date->format('M d') }} - د. {{ $a->doctor->user->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12"><hr class="my-1"><h6 class="text-muted mb-0">تفصيل الرسوم</h6></div>

                        <div class="col-md-6">
                            <label class="form-label">رسوم الاستشارة ($)</label>
                            <input type="number" name="consultation_fee" class="form-control fee-input" value="{{ old('consultation_fee', $invoice->consultation_fee) }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رسوم الأدوية / الصيدلية ($)</label>
                            <input type="number" name="medicine_fee" class="form-control fee-input" value="{{ old('medicine_fee', $invoice->medicine_fee) }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رسوم الفحوصات / المختبر ($)</label>
                            <input type="number" name="test_fee" class="form-control fee-input" value="{{ old('test_fee', $invoice->test_fee) }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رسوم أخرى ($)</label>
                            <input type="number" name="other_fee" class="form-control fee-input" value="{{ old('other_fee', $invoice->other_fee) }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الخصم ($)</label>
                            <input type="number" name="discount" class="form-control fee-input" value="{{ old('discount', $invoice->discount) }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ الاستحقاق</label>
                            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $invoice->due_date?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">الملاحظات</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="ملاحظات اختيارية...">{{ old('notes', $invoice->notes) }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>تحديث الفاتورة</button>
                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Summary Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="card sticky-top" style="top:80px;">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0 text-white"><i class="fas fa-calculator me-2"></i>ملخص الفاتورة</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">الاستشارة:</span>
                    <span id="sum-consultation">$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">الأدوية:</span>
                    <span id="sum-medicine">$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">الفحوصات / المختبر:</span>
                    <span id="sum-test">$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">أخرى:</span>
                    <span id="sum-other">$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2 text-danger">
                    <span>الخصم:</span>
                    <span id="sum-discount">-$0.00</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>الإجمالي:</span>
                    <span id="sum-total" class="text-primary">$0.00</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function updateSummary() {
    const c = parseFloat(document.querySelector('[name=consultation_fee]').value) || 0;
    const m = parseFloat(document.querySelector('[name=medicine_fee]').value) || 0;
    const t = parseFloat(document.querySelector('[name=test_fee]').value) || 0;
    const o = parseFloat(document.querySelector('[name=other_fee]').value) || 0;
    const d = parseFloat(document.querySelector('[name=discount]').value) || 0;
    const total = Math.max(0, c + m + t + o - d);
    document.getElementById('sum-consultation').textContent = '$' + c.toFixed(2);
    document.getElementById('sum-medicine').textContent = '$' + m.toFixed(2);
    document.getElementById('sum-test').textContent = '$' + t.toFixed(2);
    document.getElementById('sum-other').textContent = '$' + o.toFixed(2);
    document.getElementById('sum-discount').textContent = '-$' + d.toFixed(2);
    document.getElementById('sum-total').textContent = '$' + total.toFixed(2);
}
document.querySelectorAll('.fee-input').forEach(el => el.addEventListener('input', updateSummary));
updateSummary();
</script>
@endpush
