@extends('layouts.app')
@section('title', 'Stock Movements')
@section('page-title', 'Stock Movements')
@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between mb-3">
        <h5 class="fw-bold">All Movements</h5>
        <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-secondary">Back to Inventory</a>
    </div>
    <table class="table table-hover table-sm">
        <thead><tr><th>Date</th><th>Product</th><th>Type</th><th>Quantity</th><th>Reference</th><th>User</th><th>Notes</th></tr></thead>
        <tbody>
            @foreach($movements as $m)
            <tr>
                <td>{{ $m->created_at->format('d M H:i') }}</td>
                <td>{{ $m->product->product_name ?? 'N/A' }}</td>
                <td><span class="badge bg-{{ $m->type == 'purchase' ? 'success' : ($m->type == 'sale' ? 'danger' : 'info') }}">{{ ucfirst($m->type) }}</span></td>
                <td class="{{ $m->quantity > 0 ? 'text-success' : 'text-danger' }} fw-bold">{{ $m->quantity > 0 ? '+' : '' }}{{ $m->quantity }}</td>
                <td>{{ $m->reference_type ? $m->reference_type . ' #' . $m->reference_id : '-' }}</td>
                <td>{{ $m->user->name ?? 'System' }}</td>
                <td>{{ $m->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $movements->links() }}
</div>
@endsection
