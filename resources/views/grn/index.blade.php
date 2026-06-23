@extends('layouts.app')
@section('title', 'Goods Received Notes')
@section('page-title', 'Goods Received Notes')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5 class="fw-bold">All GRNs</h5>
    <a href="{{ route('grn.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> New GRN</a>
</div>
<div class="table-container">
    <table class="table table-hover table-sm">
        <thead><tr><th>GRN #</th><th>PO #</th><th>Supplier</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($grns as $g)
            <tr>
                <td><code>{{ $g->grn_number }}</code></td>
                <td>{{ $g->purchaseOrder->po_number ?? 'N/A' }}</td>
                <td>{{ $g->purchaseOrder->supplier->company_name ?? 'N/A' }}</td>
                <td>{{ $g->received_date->format('d M Y') }}</td>
                <td><span class="badge bg-{{ $g->status == 'fully_received' ? 'success' : 'warning' }}">{{ str_replace('_', ' ', ucfirst($g->status)) }}</span></td>
                <td><a href="{{ route('grn.show', $g->id) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $grns->links() }}
</div>
@endsection
