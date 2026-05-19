<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة {{ $invoice->invoice_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
        .invoice-header { border-bottom: 3px solid #2c7be5; margin-bottom: 2rem; padding-bottom: 1rem; }
        .invoice-footer { border-top: 1px solid #dee2e6; margin-top: 2rem; padding-top: 1rem; }
    </style>
</head>
<body class="p-4">
    <div class="no-print mb-3">
        <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print me-2"></i>طباعة</button>
        <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-secondary ms-2">رجوع</a>
    </div>
    <div class="invoice-header d-flex justify-content-between align-items-start">
        <div>
            <h2 class="fw-bold text-primary mb-1">نظام إدارة المستشفى</h2>
            <p class="text-muted mb-0">فاتورة طبية</p>
        </div>
        <div class="text-end">
            <h4 class="fw-bold">فاتورة #{{ $invoice->invoice_number }}</h4>
            <p class="mb-0 text-muted">تاريخ الإصدار: {{ $invoice->invoice_date->format('F d, Y') }}</p>
            @if($invoice->due_date)<p class="mb-0 text-muted">تاريخ الاستحقاق: {{ $invoice->due_date->format('F d, Y') }}</p>@endif
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-6">
            <h6 class="fw-bold text-muted text-uppercase mb-2">فاتورة إلى:</h6>
            <div class="fw-bold">{{ $invoice->patient->name ?? 'N/A' }}</div>
            @if($invoice->patient)<div>{{ $invoice->patient->phone }}</div><div class="text-muted">{{ $invoice->patient->email ?? '' }}</div>@endif
        </div>
        <div class="col-6 text-end">
            @if($invoice->doctor)
            <h6 class="fw-bold text-muted text-uppercase mb-2">الطبيب المعالج:</h6>
            <div class="fw-bold">{{ $invoice->doctor->user->name ?? 'N/A' }}</div>
            <div class="text-muted">{{ $invoice->doctor->specialization }}</div>
            @endif
        </div>
    </div>
    <table class="table table-bordered">
        <thead class="table-light"><tr><th>الوصف</th><th class="text-center">الكمية</th><th class="text-end">سعر الوحدة</th><th class="text-end">الإجمالي</th></tr></thead>
        <tbody>@foreach($invoice->items as $item)<tr><td>{{ $item->description }}</td><td class="text-center">{{ $item->quantity }}</td><td class="text-end">${{ number_format($item->unit_price, 2) }}</td><td class="text-end">${{ number_format($item->total, 2) }}</td></tr>@endforeach</tbody>
        <tfoot>
            <tr><td colspan="3" class="text-end">المجموع الفرعي:</td><td class="text-end">${{ number_format($invoice->subtotal, 2) }}</td></tr>
            @if($invoice->discount_amount > 0)<tr><td colspan="3" class="text-end">الخصم:</td><td class="text-end text-danger">-${{ number_format($invoice->discount_amount, 2) }}</td></tr>@endif
            @if($invoice->tax_rate > 0)<tr><td colspan="3" class="text-end">الضريبة ({{ $invoice->tax_rate }}%):</td><td class="text-end">${{ number_format($invoice->tax_amount, 2) }}</td></tr>@endif
            <tr class="table-primary fw-bold"><td colspan="3" class="text-end">الإجمالي:</td><td class="text-end fs-5">${{ number_format($invoice->total_amount, 2) }}</td></tr>
        </tfoot>
    </table>
    @if($invoice->notes)<div class="mt-3"><h6 class="fw-bold">ملاحظات:</h6><p class="text-muted">{{ $invoice->notes }}</p></div>@endif
    <div class="invoice-footer text-center text-muted small">شكرًا لك. نتمنى لك الشفاء العاجل.</div>
</body>
</html>
