@extends('layouts.admin')
@section('title','Inventory Logs')
@section('page-title','Inventory Logs')
@section('content')
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
            <thead class="table-light">
                <tr><th>Product</th><th>Type</th><th>Change</th><th>Before</th><th>After</th><th>Reason</th><th>Date</th></tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="small fw-semibold">{{ Str::limit($log->product->name ?? 'N/A',35) }}</td>
                    <td>
                        <span class="badge bg-{{ $log->type==='in'?'success':($log->type==='out'?'danger':'warning') }}">
                            {{ ucfirst($log->type) }}
                        </span>
                    </td>
                    <td class="fw-bold {{ ($log->quantity_change??0)>0?'text-success':'text-danger' }}">
                        {{ ($log->quantity_change??0)>0?'+':'' }}{{ $log->quantity_change ?? 0 }}
                    </td>
                    <td>{{ $log->quantity_before ?? 0 }}</td>
                    <td>{{ $log->quantity_after ?? 0 }}</td>
                    <td class="small text-muted">{{ $log->reason ?? '—' }}</td>
                    <td class="small text-muted">{{ $log->created_at->format('M d, Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No inventory logs yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $logs->links() }}</div>
</div>
@endsection
