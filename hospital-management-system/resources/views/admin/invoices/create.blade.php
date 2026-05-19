@extends('layouts.admin')
@section('title', 'إنشاء فاتورة')
@section('page-title', 'إنشاء فاتورة جديدة')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">الفواتير</a></li>
    <li class="breadcrumb-item active">إنشاء</li>
@endsection
@section('content')
<div class="card"><div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-file-invoice-dollar me-2 text-success"></i>تفاصيل الفاتورة</h6></div><div class="card-body">
<form action="{{ route('admin.invoices.store') }}" method="POST" id="invoice-form">@csrf
<div class="row g-3 mb-4">
<div class="col-md-6"><label class="form-label fw-semibold">المريض <span class="text-danger">*</span></label><select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required><option value="">اختر المريض</option>@foreach($patients as $patient)<option value="{{ $patient->id }}" {{ old('patient_id', request('patient_id')) == $patient->id ? 'selected' : '' }}>{{ $patient->name }} ({{ $patient->phone }})</option>@endforeach</select>@error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">الطبيب</label><select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror"><option value="">اختر الطبيب</option>@foreach($doctors as $doctor)<option value="{{ $doctor->id }}" {{ old('doctor_id', request('doctor_id')) == $doctor->id ? 'selected' : '' }}>{{ $doctor->user->name ?? 'N/A' }} - ${{ $doctor->consultation_fee }}</option>@endforeach</select>@error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">تاريخ الفاتورة <span class="text-danger">*</span></label><input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" value="{{ old('invoice_date', date('Y-m-d')) }}" required>@error('invoice_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">تاريخ الاستحقاق</label><input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}"></div>
<div class="col-md-6"><label class="form-label fw-semibold">حالة الفاتورة</label><select name="status" class="form-select"><option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>غير مدفوعة</option><option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>مدفوعة</option><option value="partial" {{ old('status') == 'partial' ? 'selected' : '' }}>جزئي</option></select></div>
<div class="col-md-6"><label class="form-label fw-semibold">طريقة الدفع</label><select name="payment_method" class="form-select"><option value="">اختر...</option><option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقدًا</option><option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>بطاقة</option><option value="insurance" {{ old('payment_method') == 'insurance' ? 'selected' : '' }}>تأمين</option><option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option></select></div>
</div>
<div class="d-flex align-items-center justify-content-between mb-3"><h6 class="fw-semibold mb-0">بنود الفاتورة</h6><button type="button" class="btn btn-sm btn-outline-primary" onclick="addItem()"><i class="fas fa-plus me-1"></i>إضافة بند</button></div>
<div id="items-container">
    <div class="item-row row g-2 mb-2 align-items-end"><div class="col-md-5"><label class="form-label small">الوصف</label><input type="text" name="items[0][description]" class="form-control form-control-sm" placeholder="وصف الخدمة"></div><div class="col-md-2"><label class="form-label small">الكمية</label><input type="number" name="items[0][quantity]" class="form-control form-control-sm item-qty" value="1" min="1" onchange="calcTotal()"></div><div class="col-md-2"><label class="form-label small">السعر</label><input type="number" step="0.01" name="items[0][unit_price]" class="form-control form-control-sm item-price" value="0" min="0" onchange="calcTotal()"></div><div class="col-md-2"><label class="form-label small">الإجمالي</label><input type="number" step="0.01" name="items[0][total]" class="form-control form-control-sm item-total" value="0" readonly></div><div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(this)"><i class="fas fa-times"></i></button></div></div>
</div>
<div class="row g-3 mt-2">
    <div class="col-md-8"><label class="form-label fw-semibold">ملاحظات</label><textarea name="notes" class="form-control" rows="3" placeholder="أي ملاحظات...">{{ old('notes') }}</textarea></div>
    <div class="col-md-4">
        <div class="border rounded p-3 bg-light">
            <div class="d-flex justify-content-between mb-2"><span>المجموع الفرعي:</span><strong id="subtotal-display">$0.00</strong></div>
            <div class="d-flex justify-content-between mb-2"><span>الخصم:</span><div class="d-flex align-items-center"><span class="me-1">$</span><input type="number" step="0.01" name="discount_amount" id="discount" class="form-control form-control-sm" style="width:80px;" value="{{ old('discount_amount', 0) }}" min="0" onchange="calcTotal()"></div></div>
            <div class="d-flex justify-content-between mb-2"><span>الضريبة (%):</span><div class="d-flex align-items-center"><input type="number" step="0.01" name="tax_rate" id="tax" class="form-control form-control-sm" style="width:60px;" value="{{ old('tax_rate', 0) }}" min="0" max="100" onchange="calcTotal()"><span class="ms-1">%</span></div></div>
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5"><span>الإجمالي:</span><span id="total-display">$0.00</span></div>
            <input type="hidden" name="subtotal" id="subtotal-input">
            <input type="hidden" name="total_amount" id="total-input">
        </div>
    </div>
</div>
<div class="mt-4 d-flex gap-2"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>إنشاء فاتورة</button><a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">إلغاء</a></div>
</form></div></div>
@endsection
@push('scripts')
<script>
let itemCount = 1;
function addItem() {
    const c = document.getElementById('items-container');
    const d = document.createElement('div');
    d.className = 'item-row row g-2 mb-2 align-items-end';
    d.innerHTML = `<div class="col-md-5"><input type="text" name="items[${itemCount}][description]" class="form-control form-control-sm" placeholder="وصف الخدمة"></div><div class="col-md-2"><input type="number" name="items[${itemCount}][quantity]" class="form-control form-control-sm item-qty" value="1" min="1" onchange="calcTotal()"></div><div class="col-md-2"><input type="number" step="0.01" name="items[${itemCount}][unit_price]" class="form-control form-control-sm item-price" value="0" min="0" onchange="calcTotal()"></div><div class="col-md-2"><input type="number" step="0.01" name="items[${itemCount}][total]" class="form-control form-control-sm item-total" value="0" readonly></div><div class="col-md-1 d-flex align-items-end"><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(this)"><i class="fas fa-times"></i></button></div>`;
    c.appendChild(d); itemCount++; calcTotal();
}
function removeItem(btn) { btn.closest('.item-row').remove(); calcTotal(); }
function calcTotal() {
    let subtotal = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        const total = qty * price;
        row.querySelector('.item-total').value = total.toFixed(2);
        subtotal += total;
    });
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const taxRate = parseFloat(document.getElementById('tax').value) || 0;
    const afterDiscount = subtotal - discount;
    const taxAmount = afterDiscount * (taxRate / 100);
    const grand = afterDiscount + taxAmount;
    document.getElementById('subtotal-display').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('total-display').textContent = '$' + grand.toFixed(2);
    document.getElementById('subtotal-input').value = subtotal.toFixed(2);
    document.getElementById('total-input').value = grand.toFixed(2);
}
calcTotal();
</script>
@endpush
