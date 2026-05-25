@extends('layouts.admin')
@section('title','Activity Logs')
@section('page-title','Activity Logs')
@section('content')
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
            <thead class="table-light"><tr><th>User</th><th>Action</th><th>Model</th><th>IP</th><th>Time</th></tr></thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="small">{{ $log->user?->name ?? 'System' }}</td>
                    <td><span class="badge bg-secondary">{{ $log->action }}</span></td>
                    <td class="small text-muted">{{ $log->model_type ? class_basename($log->model_type).' #'.$log->model_id : '—' }}</td>
                    <td class="small text-muted">{{ $log->ip_address }}</td>
                    <td class="small text-muted">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No logs</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $logs->links() }}</div>
</div>
@endsection
