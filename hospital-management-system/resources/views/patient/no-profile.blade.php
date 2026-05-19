@extends('layouts.patient')
@section('title', 'No Patient Profile')
@section('page-title', 'Profile Required')
@section('content')
<div class="text-center py-5">
    <i class="fas fa-user-times fa-5x text-muted mb-4"></i>
    <h4 class="fw-bold">No Patient Profile Found</h4>
    <p class="text-muted">Your account is not yet linked to a patient profile. Please contact the hospital reception desk.</p>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-secondary">Logout</button>
    </form>
</div>
@endsection
