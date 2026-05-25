@extends('layouts.admin')
@section('title','Brands')
@section('page-title','Brand Management')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold mb-0">All Brands</h5>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Brand</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Logo</th><th>Name</th><th>Products</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                <tr>
                    <td>
                        @if($brand->logo)
                        <img src="{{ asset('storage/'.$brand->logo) }}" height="40" class="rounded">
                        @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;"><i class="fas fa-tag text-muted"></i></div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $brand->name }}</td>
                    <td>{{ $brand->products->count() }}</td>
                    <td><span class="badge bg-{{ $brand->is_active?'success':'secondary' }}">{{ $brand->is_active?'Active':'Inactive' }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.brands.edit',$brand) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.brands.destroy',$brand) }}" method="POST" onsubmit="return confirm('Delete brand?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No brands found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $brands->links() }}</div>
</div>
@endsection
