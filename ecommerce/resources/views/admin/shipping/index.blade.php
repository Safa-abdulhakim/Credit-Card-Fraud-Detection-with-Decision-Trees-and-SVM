@extends('layouts.admin')
@section('title','Shipping Methods')
@section('page-title','Shipping Methods')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold mb-0">Shipping Methods</h5>
    <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Method</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Name</th><th>Carrier</th><th>Base Cost</th><th>Est. Days</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($methods as $method)
                <tr>
                    <td class="fw-semibold">{{ $method->name }}</td>
                    <td class="text-muted">{{ $method->carrier ?? '—' }}</td>
                    <td>{{ $method->base_cost > 0 ? '$'.number_format($method->base_cost,2) : '<span class="badge bg-success">FREE</span>' }}</td>
                    <td>{{ $method->estimated_days }} days</td>
                    <td>
                        <span class="badge bg-{{ $method->is_active?'success':'secondary' }}">
                            {{ $method->is_active?'Active':'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.shipping.edit',$method) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.shipping.destroy',$method) }}" method="POST" onsubmit="return confirm('Delete this shipping method?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No shipping methods configured</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
