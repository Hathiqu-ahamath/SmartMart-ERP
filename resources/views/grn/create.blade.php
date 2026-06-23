@extends('layouts.app')
@section('title', 'Receive Goods')
@section('page-title', 'Goods Received Note')
@section('content')
<div class="table-container">
    <form method="POST" action="{{ route('grn.store') }}">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-5">
                <label class="form-label">Purchase Order</label>
                <select name="purchase_order_id" id="poSelect" class="form-select" required>
                    <option value="">Select PO</option>
                    @foreach($purchaseOrders as $po)
                    <option value="{{ $po->id }}" {{ request('po_id') == $po->id ? 'selected' : '' }}>{{ $po->po_number }} - {{ $po->supplier->company_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Received Date</label>
                <input type="date" name="received_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
        </div>

        <div id="poItems">
            <p class="text-muted">Select a Purchase Order to load items.</p>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Receive Goods</button>
            <a href="{{ route('grn.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<template id="itemRowTemplate">
    <tr>
        <td class="item-product-name"></td>
        <td class="item-product-code"></td>
        <td class="item-ordered-qty"></td>
        <td><input type="number" name="items[__INDEX__][received_quantity]" class="form-control form-control-sm received-qty" min="1" required></td>
        <td><input type="hidden" name="items[__INDEX__][purchase_order_item_id]" class="item-po-item-id"></td>
    </tr>
</template>
@endsection

@push('scripts')
<script>
document.getElementById('poSelect').addEventListener('change', function() {
    const poId = this.value;
    const container = document.getElementById('poItems');
    if (!poId) {
        container.innerHTML = '<p class="text-muted">Select a Purchase Order to load items.</p>';
        return;
    }

    container.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm" role="status"></div> Loading items...</div>';

    fetch('/grn/create?po_id=' + poId, { headers: { 'Accept': 'application/json' } })
        .then(r => {
            if (!r.ok) throw new Error('Failed to load items');
            return r.json();
        })
        .then(items => {
            if (!items.length) {
                container.innerHTML = '<div class="alert alert-warning">This purchase order has no items.</div>';
                return;
            }

            let html = '<div class="table-responsive"><table class="table table-sm table-bordered"><thead><tr><th>Product</th><th>Code</th><th>Ordered</th><th>Received Qty</th></tr></thead><tbody>';
            items.forEach((item, index) => {
                const rowHtml = `
                    <tr>
                        <td>${item.product?.product_name || 'Unknown'}</td>
                        <td><code>${item.product?.product_code || ''}</code></td>
                        <td>${item.quantity}</td>
                        <td>
                            <input type="number" name="items[${index}][received_quantity]" class="form-control form-control-sm" min="1" max="${item.quantity}" value="${item.quantity}" required>
                            <input type="hidden" name="items[${index}][purchase_order_item_id]" value="${item.id}">
                        </td>
                    </tr>
                `;
                html += rowHtml;
            });
            html += '</tbody></table></div>';
            container.innerHTML = html;
        })
        .catch(err => {
            container.innerHTML = '<div class="alert alert-danger">Error loading purchase order items. Please try again.</div>';
        });
});
</script>
@endpush
