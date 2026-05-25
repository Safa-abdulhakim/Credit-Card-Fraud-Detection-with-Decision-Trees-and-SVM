@extends('layouts.admin')
@section('title','Vendor Details')
@section('page-title','Vendor Details')
@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="table-card text-center mb-4">
            <div class="display-3 mb-2">🏪</div>
            <h5 class="fw-bold">{{ $vendor->store_name }}</h5>
            <p class="text-muted small">{{ $vendor->description }}</p>
            <span class="badge bg-{{ $vendor->status==='approved'?'success':($vendor->status==='pending'?'warning':'danger') }} mb-3">{{ ucfirst($vendor->status) }}</span>
            <div class="d-grid gap-2">
                @if($vendor->status==='pending')
                <form action="{{ route('admin.vendors.approve',$vendor) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-success">✓ Approve</button></form>
                @endif
                @if($vendor->status==='approved')
                <form action="{{ route('admin.vendors.suspend',$vendor) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-warning">⊘ Suspend</button></form>
                @endif
            </div>
        </div>
        <div class="table-card">
            <h6 class="fw-bold mb-3">Financial</h6>
            <div class="d-flex justify-content-between mb-2 small"><span>Commission</span><span>{{ $vendor->commission_rate }}%</span></div>
            <div class="d-flex justify-content-between mb-2 small"><span>Total Earned</span><span>${{ number_format($vendor->total_earnings,2) }}</span></div>
            <div class="d-flex justify-content-between small"><span>Pending</span><span>${{ number_format($vendor->pending_withdrawal,2) }}</span></div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="table-card">
            <h6 class="fw-bold mb-3">Products ({{ $vendor->products->count() }})</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Product</th><th>Price</th><th>Stock</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($vendor->products->take(10) as $p)
                        <tr>
                            <td>{{ Str::limit($p->name,40) }}</td>
                            <td>${{ number_format($p->price,2) }}</td>
                            <td>{{ $p->available_quantity }}</td>
                            <td><span class="badge bg-{{ $p->status==='active'?'success':'secondary' }}">{{ ucfirst($p->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-muted">No products</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
