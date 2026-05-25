@extends('layouts.admin')
@section('title','Vendor Report')
@section('page-title','Vendor Performance Report')
@section('content')
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Vendor</th><th>Products</th><th>Orders</th><th>Revenue</th><th>Commission</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($vendors ?? [] as $vendor)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $vendor->store_name }}</div>
                        <small class="text-muted">{{ $vendor->user->email }}</small>
                    </td>
                    <td>{{ $vendor->products->count() }}</td>
                    <td>{{ $vendor->orders_count ?? 0 }}</td>
                    <td class="fw-bold">${{ number_format($vendor->total_earnings,2) }}</td>
                    <td>{{ $vendor->commission_rate }}%</td>
                    <td>
                        <span class="badge bg-{{ $vendor->status==='approved'?'success':($vendor->status==='pending'?'warning':'danger') }}">
                            {{ ucfirst($vendor->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.vendors.show',$vendor) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No vendors found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
