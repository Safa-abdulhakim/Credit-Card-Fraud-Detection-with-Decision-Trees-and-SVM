@extends('layouts.admin')
@section('title', 'Invoices')
@section('page-title', 'Invoices')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Invoices</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Create Invoice</a>
@endsection
@section('content')
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Invoice # or patient name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i> Search</button>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Invoice #</th>
                        <th>Patient</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Remaining</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $inv)
                    <tr>
                        <td><span class="fw-semibold text-primary">{{ $inv->invoice_number }}</span></td>
                        <td>{{ $inv->patient->name ?? 'N/A' }}</td>
                        <td>${{ number_format($inv->total_amount, 2) }}</td>
                        <td class="text-success">${{ number_format($inv->paid_amount, 2) }}</td>
                        <td class="{{ $inv->remaining_amount > 0 ? 'text-danger' : 'text-success' }}">${{ number_format($inv->remaining_amount, 2) }}</td>
                        <td>
                            @php
                                $statusMap = ['paid'=>'success','partial'=>'warning','unpaid'=>'danger'];
                                $statusBadge = $statusMap[$inv->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusBadge }}">{{ ucfirst($inv->status) }}</span>
                        </td>
                        <td><small>{{ $inv->created_at->format('M d, Y') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.invoices.show', $inv) }}" class="btn btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.invoices.print', $inv) }}" class="btn btn-outline-secondary" title="Print" target="_blank"><i class="fas fa-print"></i></a>
                                <a href="{{ route('admin.invoices.edit', $inv) }}" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.invoices.destroy', $inv) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this invoice?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fas fa-file-invoice fa-2x mb-2 d-block opacity-25"></i>
                            No invoices found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($invoices->hasPages())
    <div class="card-footer">{{ $invoices->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
