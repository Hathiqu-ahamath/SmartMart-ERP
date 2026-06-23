@extends('layouts.app')
@section('title', $category->name)
@section('page-title', 'Category Details')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="table-container">
            <table class="table">
                <tr><th style="width:180px;">Name</th><td>{{ $category->name }}</td></tr>
                <tr><th>Slug</th><td><code>{{ $category->slug }}</code></td></tr>
                <tr><th>Description</th><td>{{ $category->description ?? 'N/A' }}</td></tr>
                <tr><th>Status</th><td>{!! $category->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td></tr>
                <tr><th>Products</th><td>{{ $category->products->count() }}</td></tr>
            </table>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Back</a>
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-container">
            <h6 class="fw-bold mb-3">Products in Category</h6>
            <table class="table table-sm">
                <thead><tr><th>Code</th><th>Name</th><th>Price</th><th>Stock</th></tr></thead>
                <tbody>
                    @forelse($category->products as $p)
                    <tr>
                        <td><code>{{ $p->product_code }}</code></td>
                        <td>{{ $p->product_name }}</td>
                        <td>${{ number_format($p->selling_price, 2) }}</td>
                        <td>{{ $p->quantity }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">No products in this category</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection