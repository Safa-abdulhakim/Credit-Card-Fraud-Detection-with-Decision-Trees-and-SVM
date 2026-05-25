@extends('layouts.admin')
@section('title','Coupons')
@section('page-title','Coupon Management')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold mb-0">Coupons</h5>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Coupon</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>Code</th><th>Type</th><th>Value</th><th>Min Order</th><th>Usage</th><th>Expires</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td class="fw-bold font-monospace">{{ $coupon->code }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($coupon->type) }}</span></td>
                    <td>{{ $coupon->type==='percentage'?$coupon->value.'%':'$'.number_format($coupon->value,2) }}</td>
                    <td>{{ $coupon->minimum_amount?'$'.number_format($coupon->minimum_amount,2):'—' }}</td>
                    <td>{{ $coupon->usage_count }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                    <td class="small">{{ $coupon->expires_at?$coupon->expires_at->format('M d, Y'):'Never' }}</td>
                    <td><span class="badge bg-{{ $coupon->isValid()?'success':'danger' }}">{{ $coupon->isValid()?'Active':'Expired' }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.coupons.edit',$coupon) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.coupons.destroy',$coupon) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No coupons</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $coupons->links() }}</div>
</div>
@endsection
