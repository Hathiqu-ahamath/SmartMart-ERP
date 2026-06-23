@extends('layouts.app')
@section('title', $supplier->company_name)
@section('page-title', 'Supplier Details')
@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="table-container">
            <table class="table">
                <tr><th style="width:160px;">Code</th><td><code>{{ $supplier->supplier_code }}</code></td></tr>
                <tr><th>Company</th><td>{{ $supplier->company_name }}</td></tr>
                <tr><th>Contact</th><td>{{ $supplier->contact_person ?? 'N/A' }}</td></tr>
                <tr><th>Email</th><td>{{ $supplier->email ?? 'N/A' }}</td></tr>
                <tr><th>Phone</th><td>{{ $supplier->phone ?? 'N/A' }}</td></tr>
                <tr><th>Address</th><td>{{ $supplier->address ?? 'N/A' }}</td></tr>
                <tr><th>Status</th><td>{!! $supplier->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</td></tr>
            </table>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary btn-sm">Back</a>
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning btn-sm">Edit</a>
        </div>
    </div>
    <div class="col-md-7">
        <div class="table-container">
            <h6 class="fw-bold mb-3">Purchase Orders</h6>
            <table class="table table-sm">
                <thead><tr><th>PO #</th><th>Date</th><th>Amount</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($supplier->purchaseOrders()->latest()->take(10)->get() as $po)
                    <tr>
                        <td><a href="{{ route('purchases.show', $po->id) }}">{{ $po->po_number }}</a></td>
                        <td>{{ $po->order_date->format('d M Y') }}</td>
                        <td>${{ number_format($po->total_amount, 2) }}</td>
                        <td><span class="badge bg-{{ $po->status == 'approved' ? 'success' : ($po->status == 'pending' ? 'warning' : ($po->status == 'received' ? 'info' : 'secondary')) }}">{{ ucfirst($po->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-muted text-center">No purchase orders</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
