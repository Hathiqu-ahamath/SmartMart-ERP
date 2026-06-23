@extends('layouts.app')
@section('title', 'Sales')
@section('page-title', 'Sales History')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5 class="fw-bold">All Sales</h5>
    <a href="{{ route('sales.pos') }}" class="btn btn-primary btn-sm"><i class="bi bi-cart"></i> New Sale</a>
</div>
<div class="table-container">
    <table class="table table-hover table-sm">
        <thead><tr><th>Invoice</th><th>Customer</th><th>Items</th><th>Total</th><th>Cashier</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($sales as $s)
            <tr>
                <td><code>{{ $s->invoice_number }}</code></td>
                <td>{{ $s->customer_name ?? 'Walk-in' }}</td>
                <td>{{ $s->items->sum('quantity') }}</td>
                <td>${{ number_format($s->grand_total, 2) }}</td>
                <td>{{ $s->user->name ?? 'N/A' }}</td>
                <td>{{ $s->created_at->format('d M H:i') }}</td>
                <td>
                    <a href="{{ route('sales.show', $s->id) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('sales.receipt', $s->id) }}" class="btn btn-sm btn-secondary" target="_blank"><i class="bi bi-receipt"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $sales->links() }}
</div>
@endsection
