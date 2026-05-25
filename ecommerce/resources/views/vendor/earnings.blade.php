@extends('layouts.vendor')
@section('title','Earnings')
@section('page-title','My Earnings')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3 bg-success text-white">
            <div class="h4 mb-0">${{ number_format($vendor->total_earnings,2) }}</div>
            <small>Total Earned</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3 bg-warning text-dark">
            <div class="h4 mb-0">${{ number_format($vendor->pending_withdrawal,2) }}</div>
            <small>Available to Withdraw</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3 bg-info text-white">
            <div class="h4 mb-0">{{ $vendor->commission_rate }}%</div>
            <small>Commission Rate</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3 bg-primary text-white">
            <div class="h4 mb-0">{{ $withdrawals->where('status','paid')->count() }}</div>
            <small>Paid Withdrawals</small>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Withdrawal History</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Amount</th><th>Method</th><th>Status</th><th>Requested</th><th>Processed</th></tr>
                    </thead>
                    <tbody>
                        @forelse($withdrawals as $w)
                        <tr>
                            <td class="fw-bold">${{ number_format($w->amount,2) }}</td>
                            <td>{{ ucfirst(str_replace('_',' ',$w->payment_method)) }}</td>
                            <td>
                                <span class="badge bg-{{ ['pending'=>'warning','approved'=>'info','rejected'=>'danger','paid'=>'success'][$w->status] ?? 'secondary' }}">
                                    {{ ucfirst($w->status) }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $w->created_at->format('M d, Y') }}</td>
                            <td class="small text-muted">{{ $w->processed_at?->format('M d, Y') ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No withdrawals yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Request Withdrawal</div>
            <div class="card-body">
                @if($vendor->pending_withdrawal >= 50)
                <form action="{{ route('vendor.earnings.withdraw') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Amount ($)</label>
                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                               max="{{ $vendor->pending_withdrawal }}" min="50" step="0.01" required>
                        <small class="text-muted">Available: ${{ number_format($vendor->pending_withdrawal,2) }} | Min: $50</small>
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-paper-plane me-2"></i>Request Withdrawal
                    </button>
                </form>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-info-circle fa-2x mb-2 d-block text-info"></i>
                    <p class="mb-0">Minimum withdrawal is <strong>$50</strong>.<br>
                    You currently have <strong>${{ number_format($vendor->pending_withdrawal,2) }}</strong> available.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
