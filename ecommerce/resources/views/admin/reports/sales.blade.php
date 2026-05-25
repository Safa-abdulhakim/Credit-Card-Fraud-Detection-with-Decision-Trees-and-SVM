@extends('layouts.admin')
@section('title','Sales Report')
@section('page-title','Sales Report')
@section('content')
<div class="table-card mb-4">
    <h6 class="fw-bold mb-4">Monthly Sales - Last 12 Months</h6>
    <canvas id="salesChart" height="80"></canvas>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light"><tr><th>Month</th><th>Orders</th><th>Revenue</th></tr></thead>
            <tbody>
                @foreach($data as $row)
                <tr><td>{{ $row['month'] }}</td><td>{{ $row['orders'] }}</td><td class="fw-bold">${{ number_format($row['revenue'],2) }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
const d=@json($data);
new Chart(document.getElementById('salesChart'),{type:'line',data:{labels:d.map(r=>r.month),datasets:[{label:'Revenue ($)',data:d.map(r=>r.revenue),borderColor:'#0d6efd',backgroundColor:'rgba(13,110,253,.1)',fill:true,tension:.4},{label:'Orders',data:d.map(r=>r.orders),borderColor:'#198754',yAxisID:'orders'}]},options:{responsive:true,scales:{y:{beginAtZero:true},orders:{type:'linear',position:'right',beginAtZero:true,grid:{drawOnChartArea:false}}}}});
</script>
@endpush
