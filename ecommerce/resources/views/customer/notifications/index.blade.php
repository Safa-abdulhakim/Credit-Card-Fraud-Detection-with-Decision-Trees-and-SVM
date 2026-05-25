@extends('layouts.app')
@section('title','Notifications')
@section('content')
<div class="container py-5" style="max-width:700px;">
    <h3 class="fw-bold mb-4"><i class="fas fa-bell me-2"></i>Notifications</h3>
    @forelse($notifications as $notification)
    <div class="card border-0 shadow-sm mb-3 {{ $notification->read_at?'opacity-75':'' }}">
        <div class="card-body d-flex justify-content-between align-items-start">
            <div>
                <div class="fw-semibold mb-1">{{ $notification->data['message'] ?? 'New notification' }}</div>
                <small class="text-muted">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
            </div>
            @if(!$notification->read_at)
            <form action="{{ route('customer.notifications.read',$notification->id) }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-primary">Mark Read</button>
            </form>
            @else
            <span class="badge bg-secondary">Read</span>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center py-5"><i class="fas fa-bell-slash fa-4x text-muted mb-4 d-block"></i><h5>No notifications</h5></div>
    @endforelse
    <div class="mt-3">{{ $notifications->links() }}</div>
</div>
@endsection
