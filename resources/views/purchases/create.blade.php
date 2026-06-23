@extends('layouts.app')
@section('title', 'Create Purchase Order')
@section('page-title', 'Create Purchase Order')
@push('styles')
<style>
    .item-row { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 10px; }
</style>
@endpush
@section('content')
<div class="table-container">
    <form method="POST" action="{{ route('purchases.store') }}" id="poForm">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Supplier</label>
                <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $s)
                    <option value="{{ $s->id }}" {{ old('supplier_id') == $s->id ? 'selected' : '' }}>{{ $s->company_name }}</option>
                    @endforeach
                </select>
                @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Order Date</label>
                <input type="date" name="order_date" class="form-control" value="{{ old('order_date', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Expected Date</label>
                <input type="date" name="expected_date" class="form-control" value="{{ old('expected_date') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
        </div>

        <h6 class="fw-bold mb-3">Order Items</h6>
        <div id="itemsContainer">
            <div class="item-row">
                <div class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">Product</label>
                        <select name="items[0][product_id]" class="form-select product-select" required>
                            <option value="">Select Product</option>
                            @foreach($products as $p)
                            <option value="{{ $p->id }}" data-price="{{ $p->cost_price }}" data-name="{{ $p->product_name }}">{{ $p->product_name }} ({{ $p->product_code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="items[0][quantity]" class="form-control qty" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Unit Price</label>
                        <input type="number" step="0.01" name="items[0][unit_price]" class="form-control unit-price" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Total</label>
                        <input type="text" class="form-control item-total" readonly>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-item" style="margin-top: 32px;"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary btn-sm mt-2" id="addItem"><i class="bi bi-plus"></i> Add Item</button>
        <div class="mt-3 text-end">
            <strong>Total Amount: $<span id="grandTotal">0.00</span></strong>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Create Purchase Order</button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let itemIndex = 1;
document.getElementById('addItem').addEventListener('click', function() {
    const container = document.getElementById('itemsContainer');
    const firstRow = container.querySelector('.item-row');
    const newRow = firstRow.cloneNode(true);
    newRow.innerHTML = newRow.innerHTML.replace(/items\[0\]/g, `items[${itemIndex}]`);
    newRow.querySelectorAll('input').forEach(i => i.value = '');
    newRow.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
    container.appendChild(newRow);
    itemIndex++;
    bindEvents();
});
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
        const row = e.target.closest('.item-row');
        if (document.querySelectorAll('.item-row').length > 1) row.remove();
        calcTotal();
    }
});
function bindEvents() {
    document.querySelectorAll('.product-select').forEach(s => {
        s.addEventListener('change', function() {
            const price = this.options[this.selectedIndex]?.dataset?.price || 0;
            this.closest('.item-row').querySelector('.unit-price').value = price;
            calcRow(this.closest('.item-row'));
        });
    });
    document.querySelectorAll('.qty, .unit-price').forEach(i => {
        i.addEventListener('input', function() { calcRow(this.closest('.item-row')); });
    });
}
function calcRow(row) {
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const price = parseFloat(row.querySelector('.unit-price').value) || 0;
    row.querySelector('.item-total').value = (qty * price).toFixed(2);
    calcTotal();
}
function calcTotal() {
    let total = 0;
    document.querySelectorAll('.item-total').forEach(t => total += parseFloat(t.value) || 0);
    document.getElementById('grandTotal').textContent = total.toFixed(2);
}
bindEvents();
</script>
@endpush
