@extends('layouts.app')
@section('title','Edit Profile')
@section('content')
<div class="container py-5" style="max-width:600px;">
    <h3 class="fw-bold mb-4">My Profile</h3>
    <div class="card border-0 shadow-sm p-4">
        <form action="{{ route('customer.profile.update') }}" method="POST">
            @csrf @method('PATCH')
            <div class="mb-3"><label class="form-label fw-semibold">Name</label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$user->name) }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label fw-semibold">Email</label><input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label fw-semibold">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}"></div>
            <hr>
            <h6 class="fw-bold mb-3">Change Password <small class="text-muted fw-normal">(leave blank to keep current)</small></h6>
            <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="password" class="form-control @error('password') is-invalid @enderror">@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-4"><label class="form-label">Confirm New Password</label><input type="password" name="password_confirmation" class="form-control"></div>
            <button type="submit" class="btn btn-primary px-5">Save Changes</button>
        </form>
    </div>
</div>
@endsection
