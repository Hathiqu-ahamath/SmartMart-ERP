@extends('layouts.app')
@section('title', 'Products')
@section('page-title', 'Product Management')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5 class="fw-bold">All Products</h5>
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> New Product</a>
</div>
<div class="table-container">
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name, code, barcode..." value="{{ $query ?? '' }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Search</button>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">Clear</a>
        </div>
    </form>
    <table class="table table-hover table-sm">
        <thead>
            <tr><th>Code</th><th>Name</th><th>Category</th><th>Price</th><th>Qty</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td><code>{{ $p->product_code }}</code></td>
                <td>{{ $p->product_name }}</td>
                <td>{{ $p->category->name ?? 'N/A' }}</td>
                <td>${{ number_format($p->selling_price, 2) }}</td>
                <td>
                    <span class="badge bg-{{ $p->quantity <= $p->reorder_level ? 'danger' : 'success' }}">{{ $p->quantity }}</span>
                </td>
                <td>{!! $p->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td>
                <td>
                    <a href="{{ route('products.show', $p->id) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('products.edit', $p->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete product?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
</div>
@endsection
