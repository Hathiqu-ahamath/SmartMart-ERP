@extends('layouts.app')
@section('title', 'Purchase Orders')
@section('page-title', 'Purchase Orders')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5 class="fw-bold">All Purchase Orders</h5>
    <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> New PO</a>
</div>
<div class="table-container">
    <table class="table table-hover table-sm">
        <thead><tr><th>PO #</th><th>Supplier</th><th>Date</th><th>Amount</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($orders as $po)
            <tr>
                <td><code>{{ $po->po_number }}</code></td>
                <td>{{ $po->supplier->company_name ?? 'N/A' }}</td>
                <td>{{ $po->order_date->format('d M Y') }}</td>
                <td>${{ number_format($po->total_amount, 2) }}</td>
                <td>
                    <span class="badge bg-{{ $po->status == 'approved' ? 'success' : ($po->status == 'pending' ? 'warning' : ($po->status == 'received' ? 'info' : ($po->status == 'cancelled' ? 'danger' : 'secondary'))) }}">
                        {{ ucfirst($po->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('purchases.show', $po->id) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                    @if($po->canApprove())
                        <form action="{{ route('purchases.approve', $po->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-success" onclick="return confirm('Approve this PO?')"><i class="bi bi-check-lg"></i></button>
                        </form>
                    @endif
                    @if(in_array($po->status, ['draft', 'pending', 'approved']))
                        <form action="{{ route('purchases.cancel', $po->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Cancel this PO?')"><i class="bi bi-x-lg"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>
@endsection
