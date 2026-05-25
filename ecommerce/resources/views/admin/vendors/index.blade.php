@extends('layouts.admin')
@section('title','Vendors')
@section('page-title','Vendor Management')
@section('content')
<div class="table-card">
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><select name="status" class="form-select"><option value="">All Statuses</option><option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option><option value="approved" {{ request('status')==='approved'?'selected':'' }}>Approved</option><option value="suspended" {{ request('status')==='suspended'?'selected':'' }}>Suspended</option></select></div>
        <div class="col-auto"><button type="submit" class="btn btn-primary">Filter</button><a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary ms-2">Reset</a></div>
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>Store</th><th>Owner</th><th>Commission</th><th>Earnings</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($vendors as $vendor)
                <tr>
                    <td><div class="fw-semibold">{{ $vendor->store_name }}</div><small class="text-muted">{{ $vendor->city }}</small></td>
                    <td>{{ $vendor->user->name }}<br><small class="text-muted">{{ $vendor->user->email }}</small></td>
                    <td>{{ $vendor->commission_rate }}%</td>
                    <td>${{ number_format($vendor->total_earnings,2) }}</td>
                    <td>
                        @switch($vendor->status)
                            @case('approved') <span class="badge bg-success">Approved</span> @break
                            @case('pending') <span class="badge bg-warning">Pending</span> @break
                            @case('suspended') <span class="badge bg-danger">Suspended</span> @break
                        @endswitch
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.vendors.show',$vendor) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            @if($vendor->status==='pending')<form action="{{ route('admin.vendors.approve',$vendor) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success"><i class="fas fa-check"></i></button></form>@endif
                            @if($vendor->status==='approved')<form action="{{ route('admin.vendors.suspend',$vendor) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-warning"><i class="fas fa-ban"></i></button></form>@endif
                            <form action="{{ route('admin.vendors.destroy',$vendor) }}" method="POST" onsubmit="return confirm('Delete vendor?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No vendors found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $vendors->links() }}</div>
</div>
@endsection
