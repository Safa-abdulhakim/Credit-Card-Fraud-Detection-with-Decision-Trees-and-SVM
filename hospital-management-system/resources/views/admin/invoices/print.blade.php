<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طباعة الفاتورة - {{ $invoice->invoice_number }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fff; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
        .invoice-header { border-bottom: 3px solid #0d6efd; padding-bottom: 1rem; margin-bottom: 1.5rem; }
    </style>
</head>
<body class="p-4">
    <div class="no-print mb-3">
        <button onclick="window.print()" class="btn btn-primary btn-sm me-2"><i class="fas fa-print me-1"></i>طباعة الفاتورة</button>
        <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-secondary btn-sm">رجوع</a>
    </div>

    <div class="container" style="max-width:750px;">
        <div class="invoice-header d-flex justify-content-between align-items-start">
            <div>
                <h2 class="fw-bold text-primary mb-1">فاتورة</h2>
                <p class="text-muted mb-0">رقم الفاتورة: <strong>{{ $invoice->invoice_number }}</strong></p>
            </div>
            <div class="text-end">
                <h4 class="fw-bold mb-1">MediCare HMS</h4>
                <p class="text-muted small mb-0">نظام إدارة المستشفى</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <h6 class="text-muted mb-2">فاتورة إلى</h6>
                <p class="fw-semibold mb-1">{{ $invoice->patient->name ?? 'N/A' }}</p>
                @if($invoice->patient->phone ?? false)
                    <p class="text-muted small mb-0">{{ $invoice->patient->phone }}</p>
                @endif
                @if($invoice->patient->address ?? false)
                    <p class="text-muted small mb-0">{{ $invoice->patient->address }}</p>
                @endif
            </div>
            <div class="col-6 text-end">
                <p class="mb-1"><span class="text-muted">تاريخ الفاتورة:</span> <strong>{{ $invoice->created_at->format('M d, Y') }}</strong></p>
                @if($invoice->due_date)
                    <p class="mb-1"><span class="text-muted">تاريخ الاستحقاق:</span> <strong>{{ $invoice->due_date->format('M d, Y') }}</strong></p>
                @endif
                @php
                    $statusLabels = ['paid'=>'مدفوع بالكامل','partial'=>'مدفوع جزئياً','unpaid'=>'غير مدفوع'];
                    $statusColors = ['paid'=>'success','partial'=>'warning','unpaid'=>'danger'];
                    $statusLabel = $statusLabels[$invoice->status] ?? $invoice->status;
                    $statusColor = $statusColors[$invoice->status] ?? 'secondary';
                @endphp
                <p class="mb-0"><span class="badge bg-{{ $statusColor }}">{{ $statusLabel }}</span></p>
            </div>
        </div>

        <table class="table table-bordered mb-4">
            <thead class="table-light">
                <tr>
                    <th>الوصف</th>
                    <th class="text-end">المبلغ</th>
                </tr>
            </thead>
            <tbody>
                @if($invoice->consultation_fee > 0)
                <tr><td>رسوم الاستشارة</td><td class="text-end">${{ number_format($invoice->consultation_fee, 2) }}</td></tr>
                @endif
                @if($invoice->medicine_fee > 0)
                <tr><td>الأدوية / الصيدلية</td><td class="text-end">${{ number_format($invoice->medicine_fee, 2) }}</td></tr>
                @endif
                @if($invoice->test_fee > 0)
                <tr><td>المختبر / الفحوصات</td><td class="text-end">${{ number_format($invoice->test_fee, 2) }}</td></tr>
                @endif
                @if($invoice->other_fee > 0)
                <tr><td>رسوم أخرى</td><td class="text-end">${{ number_format($invoice->other_fee, 2) }}</td></tr>
                @endif
                @if($invoice->discount > 0)
                <tr class="text-danger"><td>الخصم</td><td class="text-end">-${{ number_format($invoice->discount, 2) }}</td></tr>
                @endif
            </tbody>
            <tfoot>
                <tr class="fw-bold table-light">
                    <td>الإجمالي الكلي</td>
                    <td class="text-end fs-5">${{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
                <tr class="text-success">
                    <td>المبلغ المدفوع</td>
                    <td class="text-end">${{ number_format($invoice->paid_amount, 2) }}</td>
                </tr>
                @if($invoice->remaining_amount > 0)
                <tr class="text-danger fw-bold">
                    <td>الرصيد المستحق</td>
                    <td class="text-end">${{ number_format($invoice->remaining_amount, 2) }}</td>
                </tr>
                @endif
            </tfoot>
        </table>

        @if($invoice->notes)
        <div class="p-3 bg-light rounded mb-4">
            <h6 class="text-muted small mb-1">الملاحظات</h6>
            <p class="mb-0 small">{{ $invoice->notes }}</p>
        </div>
        @endif

        <div class="text-center text-muted mt-5 pt-3 border-top">
            <p class="mb-0">شكراً على ثقتكم</p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</body>
</html>
