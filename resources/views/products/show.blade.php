@extends('layouts.app')
@section('title', $product->product_name)
@section('page-title', 'Product Details')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="table-container">
            <table class="table">
                <tr><th style="width:180px;">Product Code</th><td><code>{{ $product->product_code }}</code></td></tr>
                <tr><th>Name</th><td>{{ $product->product_name }}</td></tr>
                <tr><th>Category</th><td>{{ $product->category->name ?? 'N/A' }}</td></tr>
                <tr><th>Cost Price</th><td>${{ number_format($product->cost_price, 2) }}</td></tr>
                <tr><th>Selling Price</th><td>${{ number_format($product->selling_price, 2) }}</td></tr>
                <tr><th>Quantity</th><td><span class="badge bg-{{ $product->isLowStock() ? 'danger' : 'success' }} fs-6">{{ $product->quantity }}</span></td></tr>
                <tr><th>Reorder Level</th><td>{{ $product->reorder_level }}</td></tr>
                <tr><th>Expiry Date</th><td>{{ $product->expiry_date ? $product->expiry_date->format('d M Y') : 'N/A' }}</td></tr>
                <tr><th>Barcode</th><td>{{ $product->barcode ?? 'N/A' }}</td></tr>
                <tr><th>Status</th><td>{!! $product->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td></tr>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-container">
            <h6 class="fw-bold mb-3">Stock Movements</h6>
            <table class="table table-sm">
                <thead><tr><th>Date</th><th>Type</th><th>Qty</th><th>User</th></tr></thead>
                <tbody>
                    @forelse($product->stockMovements()->latest()->take(10)->get() as $m)
                    <tr>
                        <td>{{ $m->created_at->format('d M H:i') }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($m->type) }}</span></td>
                        <td class="{{ $m->quantity > 0 ? 'text-success' : 'text-danger' }}">{{ $m->quantity > 0 ? '+' : '' }}{{ $m->quantity }}</td>
                        <td>{{ $m->user->name ?? 'System' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">No movements</td></tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Back to Products</a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
        </div>
    </div>
</div>
@endsection
