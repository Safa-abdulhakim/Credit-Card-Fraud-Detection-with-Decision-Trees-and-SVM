@extends('layouts.admin')
@section('title','Edit User')
@section('page-title','Edit User')
@section('content')
<div style="max-width:600px;">
    <div class="table-card">
        <form action="{{ route('admin.users.update',$user) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3"><label class="form-label fw-semibold">Name</label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$user->name) }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label fw-semibold">Email</label><input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label fw-semibold">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}"></div>
            <div class="mb-4"><label class="form-label fw-semibold">Role</label>
                <select name="role_id" class="form-select">
                    @foreach($roles as $role)<option value="{{ $role->id }}" {{ $user->role_id==$role->id?'selected':'' }}>{{ $role->display_name }}</option>@endforeach
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">Update</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
