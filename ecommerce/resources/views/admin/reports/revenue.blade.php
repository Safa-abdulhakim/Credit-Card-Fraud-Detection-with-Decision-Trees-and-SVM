@extends('layouts.admin')
@section('title','Revenue Report')
@section('page-title','Revenue Report')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="h4 text-success mb-0">${{ number_format($stats['total_revenue'] ?? 0,2) }}</div>
            <small class="text-muted">Total Revenue</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="h4 text-primary mb-0">${{ number_format($stats['month_revenue'] ?? 0,2) }}</div>
            <small class="text-muted">This Month</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="h4 text-warning mb-0">${{ number_format($stats['avg_order'] ?? 0,2) }}</div>
            <small class="text-muted">Avg Order Value</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="table-card text-center">
            <div class="h4 text-info mb-0">{{ $stats['total_orders'] ?? 0 }}</div>
            <small class="text-muted">Total Orders</small>
        </div>
    </div>
</div>
<div class="table-card mb-4">
    <h6 class="fw-bold mb-4">Monthly Revenue (Last 12 Months)</h6>
    <canvas id="revenueChart" height="80"></canvas>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light"><tr><th>Month</th><th>Orders</th><th>Revenue</th><th>Avg Order</th></tr></thead>
            <tbody>
                @foreach($monthlyRevenue ?? [] as $row)
                <tr>
                    <td>{{ $row['month'] }}</td>
                    <td>{{ $row['orders'] }}</td>
                    <td class="fw-bold">${{ number_format($row['revenue'],2) }}</td>
                    <td>${{ $row['orders']>0 ? number_format($row['revenue']/$row['orders'],2) : '0.00' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
const data = @json($monthlyRevenue ?? []);
if (data.length) {
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: data.map(d => d.month),
            datasets: [{
                label: 'Revenue ($)',
                data: data.map(d => d.revenue),
                backgroundColor: 'rgba(13,110,253,.7)',
                borderRadius: 4
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
}
</script>
@endpush
