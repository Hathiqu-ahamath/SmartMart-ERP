@extends('layouts.app')
@section('title', 'GRN ' . $grn->grn_number)
@section('page-title', 'Goods Received Note')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="table-container mb-3">
            <div class="d-flex justify-content-between">
                <h5 class="fw-bold">GRN #{{ $grn->grn_number }}</h5>
                <span class="badge bg-{{ $grn->status == 'fully_received' ? 'success' : 'warning' }} fs-6">{{ str_replace('_', ' ', ucfirst($grn->status)) }}</span>
            </div>
            <table class="table table-sm mt-3">
                <tr><th style="width:150px;">Purchase Order</th><td>{{ $grn->purchaseOrder->po_number ?? 'N/A' }}</td></tr>
                <tr><th>Supplier</th><td>{{ $grn->purchaseOrder->supplier->company_name ?? 'N/A' }}</td></tr>
                <tr><th>Received Date</th><td>{{ $grn->received_date->format('d M Y') }}</td></tr>
                <tr><th>Received By</th><td>{{ $grn->user->name ?? 'N/A' }}</td></tr>
                <tr><th>Notes</th><td>{{ $grn->notes ?? 'N/A' }}</td></tr>
            </table>
        </div>
    </div>
</div>
<div class="table-container">
    <h6 class="fw-bold mb-3">Received Items</h6>
    <table class="table table-sm">
        <thead><tr><th>#</th><th>Product</th><th>Ordered</th><th>Received</th><th>Unit Price</th><th>Total</th></tr></thead>
        <tbody>
            @foreach($grn->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                <td>{{ $item->ordered_quantity }}</td>
                <td>{{ $item->received_quantity }}</td>
                <td>${{ number_format($item->unit_price, 2) }}</td>
                <td>${{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('grn.index') }}" class="btn btn-secondary btn-sm">Back</a>
</div>
@endsection
