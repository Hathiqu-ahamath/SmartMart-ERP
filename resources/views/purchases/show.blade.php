@extends('layouts.app')
@section('title', 'PO ' . $order->po_number)
@section('page-title', 'Purchase Order Details')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="table-container mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold">PO #{{ $order->po_number }}</h5>
                <span class="badge bg-{{ $order->status == 'approved' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'received' ? 'info' : 'secondary')) }} fs-6">{{ ucfirst($order->status) }}</span>
            </div>
            <table class="table table-sm">
                <tr><th style="width:150px;">Supplier</th><td>{{ $order->supplier->company_name ?? 'N/A' }}</td></tr>
                <tr><th>Order Date</th><td>{{ $order->order_date->format('d M Y') }}</td></tr>
                <tr><th>Expected Date</th><td>{{ $order->expected_date ? $order->expected_date->format('d M Y') : 'N/A' }}</td></tr>
                <tr><th>Created By</th><td>{{ $order->user->name ?? 'N/A' }}</td></tr>
                <tr><th>Notes</th><td>{{ $order->notes ?? 'N/A' }}</td></tr>
            </table>
        </div>
    </div>
</div>
<div class="table-container">
    <h6 class="fw-bold mb-3">Order Items</h6>
    <table class="table table-sm">
        <thead><tr><th>#</th><th>Product</th><th>Qty</th><th>Received</th><th>Unit Price</th><th>Total</th></tr></thead>
        <tbody>
            @foreach($order->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->received_quantity }}</td>
                <td>${{ number_format($item->unit_price, 2) }}</td>
                <td>${{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="fw-bold"><td colspan="5" class="text-end">Total Amount:</td><td>${{ number_format($order->total_amount, 2) }}</td></tr>
        </tfoot>
    </table>
    <div class="mt-3">
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">Back</a>
        @if($order->canApprove())
            <form action="{{ route('purchases.approve', $order->id) }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-success btn-sm" onclick="return confirm('Approve this PO?')">Approve</button>
            </form>
        @endif
        @if($order->canReceive())
            <a href="{{ route('grn.create') }}?po_id={{ $order->id }}" class="btn btn-info btn-sm">Receive Goods</a>
        @endif
    </div>
</div>
@endsection
