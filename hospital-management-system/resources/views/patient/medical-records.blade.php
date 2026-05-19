@extends('layouts.patient')
@section('title', 'السجلات الطبية')
@section('page-title', 'سجلاتي الطبية')
@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>الطبيب</th><th>التشخيص</th><th>العلاج</th><th>التاريخ</th></tr>
                </thead>
                <tbody>
                    @forelse($records as $rec)
                    <tr>
                        <td>{{ $records->firstItem() + $loop->index }}</td>
                        <td>{{ $rec->doctor->user->name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($rec->diagnosis, 80) }}</td>
                        <td>{{ Str::limit($rec->treatment, 80) }}</td>
                        <td>{{ $rec->record_date->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">لا توجد سجلات طبية</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($records->hasPages())
    <div class="card-footer">{{ $records->links() }}</div>
    @endif
</div>
@endsection
