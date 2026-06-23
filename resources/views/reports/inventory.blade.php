@extends('layouts.app')
@section('title', 'Inventory Report')
@section('page-title', 'Inventory Report')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="value text-primary">{{ $totalProducts }}</div>
            <div class="label">Total Products</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="value text-danger">{{ $lowStock }}</div>
            <div class="label">Low Stock</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="value text-warning">{{ $expired }} / {{ $expiring }}</div>
            <div class="label">Expired / Expiring</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card text-center">
            <div class="value text-success">${{ number_format($totalValue, 2) }}</div>
            <div class="label">Total Stock Value</div>
        </div>
    </div>
</div>
<div class="table-container">
    <h5 class="fw-bold mb-3">Category Summary</h5>
    <table class="table table-sm">
        <thead><tr><th>Category</th><th>Products</th><th>Total Qty</th><th>Total Value</th></tr></thead>
        <tbody>
            @foreach($categorySummary as $cs)
            <tr>
                <td>{{ $cs->category->name ?? 'N/A' }}</td>
                <td>{{ $cs->count }}</td>
                <td>{{ $cs->total_qty }}</td>
                <td>${{ number_format($cs->total_value, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td>Total</td>
                <td>{{ $totalProducts }}</td>
                <td>{{ $categorySummary->sum('total_qty') }}</td>
                <td>${{ number_format($totalValue, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
