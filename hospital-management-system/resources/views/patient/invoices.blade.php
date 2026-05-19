@extends('layouts.patient')
@section('title', 'فواتيري')
@section('page-title', 'فواتيري')
@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>رقم الفاتورة</th><th>المبلغ الإجمالي</th><th>مدفوع</th><th>الرصيد</th><th>الحالة</th><th>التاريخ</th></tr>
                </thead>
                <tbody>
                    @forelse($invoices as $inv)
                    <tr>
                        <td><strong class="text-primary">{{ $inv->invoice_number }}</strong></td>
                        <td>${{ number_format($inv->total_amount, 2) }}</td>
                        <td class="text-success">${{ number_format($inv->paid_amount, 2) }}</td>
                        <td class="{{ $inv->remaining_amount > 0 ? 'text-danger' : 'text-success' }}">
                            ${{ number_format($inv->remaining_amount, 2) }}
                        </td>
                        <td><span class="badge bg-{{ $inv->status_badge }}">{{ ucfirst($inv->status) }}</span></td>
                        <td><small>{{ $inv->created_at->format('M d, Y') }}</small></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">لا توجد فواتير</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($invoices->hasPages())
    <div class="card-footer">{{ $invoices->links() }}</div>
    @endif
</div>
@endsection
