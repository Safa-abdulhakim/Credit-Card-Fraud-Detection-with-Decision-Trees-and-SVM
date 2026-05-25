@extends('layouts.admin')
@section('title','Customer Report')
@section('page-title','Customer Report')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="table-card text-center">
            <div class="h4 text-primary mb-0">{{ $stats['total_customers'] ?? 0 }}</div>
            <small class="text-muted">Total Customers</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="table-card text-center">
            <div class="h4 text-success mb-0">{{ $stats['new_this_month'] ?? 0 }}</div>
            <small class="text-muted">New This Month</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="table-card text-center">
            <div class="h4 text-warning mb-0">{{ $stats['with_orders'] ?? 0 }}</div>
            <small class="text-muted">Customers with Orders</small>
        </div>
    </div>
</div>
<div class="table-card">
    <h6 class="fw-bold mb-3">Top Customers by Spending</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>#</th><th>Customer</th><th>Orders</th><th>Total Spent</th><th>Last Order</th><th>Joined</th></tr>
            </thead>
            <tbody>
                @forelse($topCustomers ?? [] as $index => $customer)
                <tr>
                    <td class="text-muted">{{ $index + 1 }}</td>
                    <td>
                        <div class="fw-semibold">{{ $customer->name }}</div>
                        <small class="text-muted">{{ $customer->email }}</small>
                    </td>
                    <td>{{ $customer->orders->count() }}</td>
                    <td class="fw-bold text-success">${{ number_format($customer->orders->sum('total'),2) }}</td>
                    <td class="small text-muted">{{ $customer->orders->first()?->created_at->format('M d, Y') ?? '—' }}</td>
                    <td class="small text-muted">{{ $customer->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No customer data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
