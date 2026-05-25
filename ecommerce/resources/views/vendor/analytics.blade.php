@extends('layouts.vendor')
@section('title','Analytics')
@section('page-title','Store Analytics')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Sales — Last 30 Days</div>
            <div class="card-body"><canvas id="salesChart" height="100"></canvas></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold">Top Products</div>
            <div class="card-body">
                @forelse($topProducts as $index => $product)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary">{{ $index + 1 }}</span>
                        <span class="small fw-semibold">{{ Str::limit($product->name,25) }}</span>
                    </div>
                    <span class="badge bg-success">{{ $product->sold_count }} sold</span>
                </div>
                @empty
                <p class="text-muted text-center py-3">No sales data yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Order Status Breakdown</div>
            <div class="card-body"><canvas id="statusChart" height="200"></canvas></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Recent Reviews</div>
            <div class="card-body">
                @forelse($recentReviews as $review)
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="fw-semibold small">{{ $review->user->name }}</span>
                            <div class="small text-muted">{{ Str::limit($review->product->name,30) }}</div>
                        </div>
                        <span class="text-warning small">
                            @for($i=1;$i<=5;$i++)<i class="fa{{ $i<=$review->rating?'s':'r' }} fa-star"></i>@endfor
                        </span>
                    </div>
                    @if($review->body)
                    <p class="small text-muted mb-0 mt-1">{{ Str::limit($review->body,80) }}</p>
                    @endif
                </div>
                @empty
                <p class="text-muted text-center py-3">No reviews yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
const salesData = @json($salesData ?? []);
if (salesData.length) {
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: salesData.map(d => d.date),
            datasets: [{
                label: 'Revenue ($)',
                data: salesData.map(d => d.revenue),
                borderColor: '#198754',
                backgroundColor: 'rgba(25,135,84,.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
}
const statusData = @json($statusData ?? []);
if (statusData.length) {
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusData.map(d => d.status),
            datasets: [{ data: statusData.map(d => d.count), backgroundColor: ['#ffc107','#0d6efd','#17a2b8','#198754','#dc3545'] }]
        },
        options: { responsive: true }
    });
}
</script>
@endpush
