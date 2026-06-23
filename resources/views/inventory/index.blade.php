@extends('layouts.app')
@section('title', 'Inventory')
@section('page-title', 'Inventory Management')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="value text-primary">{{ $products->total() }}</div>
            <div class="label">Total Products</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="value text-danger">{{ $lowStockCount }}</div>
            <div class="label">Low Stock Items</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="value text-warning">{{ $expiredCount }}</div>
            <div class="label">Expired Items</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="value text-success">${{ number_format($totalValue, 2) }}</div>
            <div class="label">Inventory Value</div>
        </div>
    </div>
</div>
<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-outline-secondary {{ !request('filter') ? 'active' : '' }}">All</a>
            <a href="{{ route('inventory.index', ['filter' => 'low_stock']) }}" class="btn btn-sm btn-outline-danger {{ request('filter') == 'low_stock' ? 'active' : '' }}">Low Stock</a>
            <a href="{{ route('inventory.index', ['filter' => 'expired']) }}" class="btn btn-sm btn-outline-warning {{ request('filter') == 'expired' ? 'active' : '' }}">Expired</a>
            <a href="{{ route('inventory.index', ['filter' => 'expiring']) }}" class="btn btn-sm btn-outline-info {{ request('filter') == 'expiring' ? 'active' : '' }}">Expiring Soon</a>
        </div>
        <div>
            <a href="{{ route('inventory.movements') }}" class="btn btn-sm btn-info"><i class="bi bi-arrow-left-right"></i> Movements</a>
            <a href="{{ route('inventory.adjust-form') }}" class="btn btn-sm btn-warning"><i class="bi bi-sliders"></i> Adjust</a>
        </div>
    </div>
    <table class="table table-hover table-sm">
        <thead><tr><th>Code</th><th>Product</th><th>Category</th><th>Qty</th><th>Cost Price</th><th>Value</th><th>Status</th></tr></thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td><code>{{ $p->product_code }}</code></td>
                <td>{{ $p->product_name }}</td>
                <td>{{ $p->category->name ?? 'N/A' }}</td>
                <td>
                    <span class="badge bg-{{ $p->isLowStock() ? 'danger' : 'success' }}">{{ $p->quantity }}</span>
                </td>
                <td>${{ number_format($p->cost_price, 2) }}</td>
                <td>${{ number_format($p->quantity * $p->cost_price, 2) }}</td>
                <td>
                    @if($p->quantity <= $p->reorder_level)
                        <span class="badge bg-danger">Low Stock</span>
                    @endif
                    @if($p->expiry_date && $p->expiry_date->isPast())
                        <span class="badge bg-warning">Expired</span>
                    @elseif($p->isExpiringSoon(30))
                        <span class="badge bg-info">Expiring</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
</div>
@endsection
