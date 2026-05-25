@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
{{-- Stats Cards --}}
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Total Revenue</div>
                    <div class="h3 fw-bold">${{ number_format($stats['total_revenue'], 0) }}</div>
                    <div class="small"><i class="fas fa-arrow-up me-1"></i>Today: ${{ number_format($stats['today_revenue'], 0) }}</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25"><i class="fas fa-dollar-sign fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card bg-success text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Total Orders</div>
                    <div class="h3 fw-bold">{{ number_format($stats['total_orders']) }}</div>
                    <div class="small"><i class="fas fa-clock me-1"></i>Pending: {{ $stats['pending_orders'] }}</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25"><i class="fas fa-shopping-cart fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card bg-info text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Total Users</div>
                    <div class="h3 fw-bold">{{ number_format($stats['total_users']) }}</div>
                    <div class="small"><i class="fas fa-store me-1"></i>Vendors: {{ $stats['total_vendors'] }}</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25"><i class="fas fa-users fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card bg-warning text-dark">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Total Products</div>
                    <div class="h3 fw-bold">{{ number_format($stats['total_products']) }}</div>
                    <div class="small"><i class="fas fa-exclamation-triangle me-1"></i>Low Stock: {{ $stats['low_stock'] }}</div>
                </div>
                <div class="stat-icon bg-dark bg-opacity-10"><i class="fas fa-box fa-lg"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Sales Chart --}}
    <div class="col-lg-8">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Sales Overview (Last 6 Months)</h6>
            </div>
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>
    {{-- Quick Stats --}}
    <div class="col-lg-4">
        <div class="table-card h-100">
            <h6 class="fw-bold mb-3">Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm text-start"><i class="fas fa-users me-2"></i>Manage Users</a>
                <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-success btn-sm text-start"><i class="fas fa-store me-2"></i>Manage Vendors</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-info btn-sm text-start"><i class="fas fa-box me-2"></i>Manage Products</a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-warning btn-sm text-start"><i class="fas fa-shopping-cart me-2"></i>View Orders</a>
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-outline-danger btn-sm text-start"><i class="fas fa-ticket-alt me-2"></i>Create Coupon</a>
                <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-secondary btn-sm text-start"><i class="fas fa-chart-bar me-2"></i>View Reports</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Latest Orders --}}
    <div class="col-lg-7">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Latest Orders</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @foreach($latestOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none fw-semibold">{{ $order->order_number }}</a></td>
                            <td>{{ $order->user->name }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td><span class="badge bg-{{ $order->status_badge['class'] }}">{{ $order->status_badge['label'] }}</span></td>
                            <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Low Stock & Best Products --}}
    <div class="col-lg-5">
        <div class="table-card mb-4">
            <h6 class="fw-bold mb-3 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Low Stock Alert</h6>
            @foreach($lowStock as $product)
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <span class="small fw-semibold text-truncate" style="max-width:180px;">{{ $product->name }}</span>
                <span class="badge bg-danger">{{ $product->available_quantity }} left</span>
            </div>
            @endforeach
        </div>
        <div class="table-card">
            <h6 class="fw-bold mb-3"><i class="fas fa-fire text-warning me-2"></i>Best Sellers</h6>
            @foreach($bestProducts as $product)
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                <span class="small fw-semibold text-truncate" style="max-width:180px;">{{ $product->name }}</span>
                <span class="badge bg-success">{{ $product->sold_count }} sold</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const salesData = @json($monthlySales);
new Chart(document.getElementById('salesChart'), {
    type: 'bar',
    data: {
        labels: salesData.map(d => d.month),
        datasets: [{
            label: 'Revenue ($)',
            data: salesData.map(d => d.revenue),
            backgroundColor: 'rgba(13, 110, 253, 0.6)',
            borderColor: '#0d6efd',
            borderWidth: 2,
            borderRadius: 6,
        }, {
            label: 'Orders',
            data: salesData.map(d => d.orders),
            type: 'line',
            borderColor: '#198754',
            backgroundColor: 'transparent',
            pointBackgroundColor: '#198754',
            yAxisID: 'orders',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: { beginAtZero: true, title: { display: true, text: 'Revenue ($)' } },
            orders: { type: 'linear', position: 'right', beginAtZero: true, title: { display: true, text: 'Orders' }, grid: { drawOnChartArea: false } }
        }
    }
});
</script>
@endpush
