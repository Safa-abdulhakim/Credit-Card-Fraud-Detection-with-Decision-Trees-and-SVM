@extends('layouts.admin')
@section('title', 'Create Invoice')
@section('page-title', 'Create Invoice')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">Invoices</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-file-invoice-dollar me-2 text-success"></i>Invoice Details</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.invoices.store') }}" method="POST" id="invoiceForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Patient <span class="text-danger">*</span></label>
                            <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $p)
                                    <option value="{{ $p->id }}" {{ (old('patient_id') ?? request('patient_id')) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Appointment (Optional)</label>
                            <select name="appointment_id" class="form-select">
                                <option value="">No Appointment</option>
                                @foreach($appointments as $a)
                                    <option value="{{ $a->id }}" {{ (old('appointment_id') ?? request('appointment_id')) == $a->id ? 'selected' : '' }}>
                                        {{ $a->patient->name ?? '' }} - {{ $a->appointment_date->format('M d') }} - Dr. {{ $a->doctor->user->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12"><hr class="my-1"><h6 class="text-muted mb-0">Fee Breakdown</h6></div>

                        <div class="col-md-6">
                            <label class="form-label">Consultation Fee ($)</label>
                            <input type="number" name="consultation_fee" class="form-control fee-input" value="{{ old('consultation_fee', 0) }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Medicine / Pharmacy Fee ($)</label>
                            <input type="number" name="medicine_fee" class="form-control fee-input" value="{{ old('medicine_fee', 0) }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Test / Lab Fee ($)</label>
                            <input type="number" name="test_fee" class="form-control fee-input" value="{{ old('test_fee', 0) }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Other Charges ($)</label>
                            <input type="number" name="other_fee" class="form-control fee-input" value="{{ old('other_fee', 0) }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Discount ($)</label>
                            <input type="number" name="discount" class="form-control fee-input" value="{{ old('discount', 0) }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes...">{{ old('notes') }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Create Invoice</button>
                            <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">Cancel</a>
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
                <h6 class="mb-0 text-white"><i class="fas fa-calculator me-2"></i>Invoice Summary</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Consultation:</span>
                    <span id="sum-consultation">$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Medicine:</span>
                    <span id="sum-medicine">$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tests / Lab:</span>
                    <span id="sum-test">$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Other:</span>
                    <span id="sum-other">$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2 text-danger">
                    <span>Discount:</span>
                    <span id="sum-discount">-$0.00</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total:</span>
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
