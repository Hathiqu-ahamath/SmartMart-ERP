@extends('layouts.app')
@section('title', 'Sale ' . $sale->invoice_number)
@section('page-title', 'Sale Details')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="table-container mb-3">
            <div class="d-flex justify-content-between">
                <h5 class="fw-bold">Invoice #{{ $sale->invoice_number }}</h5>
                <div>
                    <a href="{{ route('sales.receipt', $sale->id) }}" class="btn btn-sm btn-secondary" target="_blank"><i class="bi bi-receipt"></i> Receipt</a>
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
            </div>
            <table class="table table-sm mt-3">
                <tr><th style="width:150px;">Date</th><td>{{ $sale->created_at->format('d M Y H:i') }}</td></tr>
                <tr><th>Customer</th><td>{{ $sale->customer_name ?? 'Walk-in Customer' }}</td></tr>
                <tr><th>Cashier</th><td>{{ $sale->user->name ?? 'N/A' }}</td></tr>
                <tr><th>Payment Method</th><td>{{ ucfirst($sale->payment_method) }}</td></tr>
            </table>
        </div>
    </div>
</div>
<div class="table-container">
    <h6 class="fw-bold mb-3">Items</h6>
    <table class="table table-sm">
        <thead><tr><th>#</th><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
        <tbody>
            @foreach($sale->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->unit_price, 2) }}</td>
                <td>${{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-end">
        <p class="mb-1">Subtotal: ${{ number_format($sale->subtotal, 2) }}</p>
        @if($sale->discount_amount > 0)<p class="mb-1">Discount ({{ $sale->discount_percentage }}%): -${{ number_format($sale->discount_amount, 2) }}</p>@endif
        @if($sale->tax_amount > 0)<p class="mb-1">Tax ({{ $sale->tax_percentage }}%): ${{ number_format($sale->tax_amount, 2) }}</p>@endif
        <h5 class="fw-bold">Grand Total: ${{ number_format($sale->grand_total, 2) }}</h5>
    </div>
</div>
@endsection
