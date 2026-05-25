@extends('layouts.admin')
@section('title','Users')
@section('page-title','User Management')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">All Users</h5>
</div>
<div class="table-card">
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="Search name or email..." value="{{ request('search') }}"></div>
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                @foreach($roles as $role)<option value="{{ $role->name }}" {{ request('role')===$role->name?'selected':'' }}>{{ $role->display_name }}</option>@endforeach
            </select>
        </div>
        <div class="col-auto"><button type="submit" class="btn btn-primary">Filter</button><a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary ms-2">Reset</a></div>
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>User</th><th>Role</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=36&background=0d6efd&color=ffffff&rounded=true" width="36" height="36" class="rounded-circle">
                            <div><div class="fw-semibold">{{ $user->name }}</div><small class="text-muted">{{ $user->email }}</small></div>
                        </div>
                    </td>
                    <td><span class="badge bg-secondary">{{ $user->role?->display_name ?? 'No Role' }}</span></td>
                    <td><span class="badge bg-{{ $user->is_active?'success':'danger' }}">{{ $user->is_active?'Active':'Inactive' }}</span></td>
                    <td class="small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.show',$user) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.users.toggle',$user) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-{{ $user->is_active?'warning':'success' }}" title="{{ $user->is_active?'Deactivate':'Activate' }}">
                                    <i class="fas fa-{{ $user->is_active?'ban':'check' }}"></i>
                                </button>
                            </form>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy',$user) }}" method="POST" onsubmit="return confirm('Delete user?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No users found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $users->links() }}</div>
</div>
@endsection
