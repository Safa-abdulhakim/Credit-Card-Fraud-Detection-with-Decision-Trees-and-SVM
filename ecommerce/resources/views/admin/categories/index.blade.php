@extends('layouts.admin')
@section('title','Categories')
@section('page-title','Category Management')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold mb-0">All Categories</h5>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Category</a>
</div>
<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>Name</th><th>Parent</th><th>Products</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="fw-semibold">{{ $category->name }}</td>
                    <td class="text-muted small">{{ $category->parent?->name ?? '—' }}</td>
                    <td>{{ $category->products->count() }}</td>
                    <td><span class="badge bg-{{ $category->is_active?'success':'secondary' }}">{{ $category->is_active?'Active':'Inactive' }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.categories.edit',$category) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.categories.destroy',$category) }}" method="POST" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No categories</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $categories->links() }}</div>
</div>
@endsection
