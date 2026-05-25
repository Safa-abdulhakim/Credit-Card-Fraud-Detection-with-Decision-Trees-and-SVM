@extends('layouts.admin')
@section('title','Reviews')
@section('page-title','Review Moderation')
@section('content')
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>Product</th><th>Customer</th><th>Rating</th><th>Review</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td class="small fw-semibold">{{ Str::limit($review->product->name,30) }}</td>
                    <td class="small">{{ $review->user->name }}</td>
                    <td class="text-warning small">@for($i=1;$i<=5;$i++)<i class="fa{{ $i<=$review->rating?'s':'r' }} fa-star"></i>@endfor</td>
                    <td class="small text-muted">{{ Str::limit($review->body,60) }}</td>
                    <td>
                        @switch($review->status)
                            @case('approved') <span class="badge bg-success">Approved</span> @break
                            @case('pending') <span class="badge bg-warning">Pending</span> @break
                            @case('rejected') <span class="badge bg-danger">Rejected</span> @break
                        @endswitch
                    </td>
                    <td class="small text-muted">{{ $review->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            @if($review->status!=='approved')<form action="{{ route('admin.reviews.approve',$review) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success" title="Approve"><i class="fas fa-check"></i></button></form>@endif
                            @if($review->status!=='rejected')<form action="{{ route('admin.reviews.reject',$review) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-warning" title="Reject"><i class="fas fa-times"></i></button></form>@endif
                            <form action="{{ route('admin.reviews.destroy',$review) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No reviews</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $reviews->links() }}</div>
</div>
@endsection
