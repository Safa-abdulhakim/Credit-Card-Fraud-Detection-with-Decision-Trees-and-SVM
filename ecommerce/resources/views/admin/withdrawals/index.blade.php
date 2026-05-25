@extends('layouts.admin')
@section('title','Withdrawals')
@section('page-title','Withdrawal Requests')
@section('content')
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>Vendor</th><th>Amount</th><th>Method</th><th>Status</th><th>Requested</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($withdrawals as $w)
                <tr>
                    <td><div class="fw-semibold">{{ $w->vendor->store_name }}</div><small class="text-muted">{{ $w->vendor->user->email }}</small></td>
                    <td class="fw-bold">${{ number_format($w->amount,2) }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$w->payment_method)) }}</td>
                    <td><span class="badge bg-{{ ['pending'=>'warning','approved'=>'success','rejected'=>'danger','paid'=>'info'][$w->status] }}">{{ ucfirst($w->status) }}</span></td>
                    <td class="small text-muted">{{ $w->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($w->status==='pending')
                        <div class="d-flex gap-1">
                            <form action="{{ route('admin.withdrawals.approve',$w) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-sm btn-success">Approve</button></form>
                            <form action="{{ route('admin.withdrawals.reject',$w) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-sm btn-danger">Reject</button></form>
                        </div>
                        @else
                        <span class="text-muted small">Processed {{ $w->processed_at?->format('M d, Y') }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No withdrawal requests</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $withdrawals->links() }}</div>
</div>
@endsection
