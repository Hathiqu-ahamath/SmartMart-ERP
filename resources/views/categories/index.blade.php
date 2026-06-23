@extends('layouts.app')
@section('title', 'Categories')
@section('page-title', 'Category Management')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5 class="fw-bold">All Categories</h5>
    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> New Category</a>
</div>
<div class="table-container">
    <table class="table table-hover">
        <thead><tr><th>Name</th><th>Slug</th><th>Products</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($categories as $cat)
            <tr>
                <td>{{ $cat->name }}</td>
                <td><code>{{ $cat->slug }}</code></td>
                <td>{{ $cat->products->count() }}</td>
                <td>{!! $cat->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                <td>
                    <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete category?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
