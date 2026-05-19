@extends('layouts.patient')
@section('title', 'My Invoices')
@section('page-title', 'My Invoices')
@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Invoice #</th><th>Total Amount</th><th>Paid</th><th>Balance</th><th>Status</th><th>Date</th></tr>
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
                    <tr><td colspan="6" class="text-center text-muted py-4">No invoices found</td></tr>
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
