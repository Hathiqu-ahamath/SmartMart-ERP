@extends('layouts.app')
@section('title', 'Daily Sales Report')
@section('page-title', 'Daily Sales Report')
@section('content')
<div class="table-container mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-auto">
            <label class="form-label">Select Date</label>
            <input type="date" name="date" class="form-control" value="{{ $date->format('Y-m-d') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> View</button>
        </div>
    </form>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stats-card text-center">
            <div class="value text-primary">${{ number_format($totalSales, 2) }}</div>
            <div class="label">Total Sales for {{ $date->format('d M Y') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card text-center">
            <div class="value text-success">{{ $totalTransactions }}</div>
            <div class="label">Total Transactions</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card text-center">
            <div class="value text-info">${{ number_format($totalProfit, 2) }}</div>
            <div class="label">Total Profit</div>
        </div>
    </div>
</div>
<div class="table-container">
    <h5 class="fw-bold mb-3">Sales Transactions</h5>
    <table class="table table-hover table-sm">
        <thead><tr><th>Invoice</th><th>Customer</th><th>Items</th><th>Total</th><th>Profit</th><th>Cashier</th><th>Time</th></tr></thead>
        <tbody>
            @forelse($sales as $s)
            <tr>
                <td><code>{{ $s->invoice_number }}</code></td>
                <td>{{ $s->customer_name ?? 'Walk-in' }}</td>
                <td>{{ $s->items->sum('quantity') }}</td>
                <td>${{ number_format($s->grand_total, 2) }}</td>
                <td class="text-success">${{ number_format($s->items->sum(fn($i) => ($i->unit_price - $i->cost_price) * $i->quantity), 2) }}</td>
                <td>{{ $s->user->name ?? 'N/A' }}</td>
                <td>{{ $s->created_at->format('H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted">No sales for this date</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
