@extends('layouts.app')
@section('title', 'POS Billing')
@section('page-title', 'Point of Sale')
@push('styles')
<style>
    .pos-container { display: flex; gap: 20px; }
    .pos-products { flex: 1; }
    .pos-cart { width: 420px; min-width: 420px; }
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; max-height: 520px; overflow-y: auto; padding: 4px; }
    .product-card { border: 1.5px solid #E5E7EB; border-radius: 12px; padding: 14px 10px; text-align: center; cursor: pointer; transition: all 0.2s; background: #fff; }
    .product-card:hover { border-color: #A78BFA; box-shadow: 0 4px 16px rgba(124,58,237,0.12); transform: translateY(-3px); }
    .product-card .name { font-size: 0.8rem; font-weight: 600; color: #1F2937; line-height: 1.3; }
    .product-card .price { color: #7C3AED; font-weight: 700; font-size: 1.1rem; margin: 6px 0; }
    .product-card .stock { font-size: 0.7rem; color: #9CA3AF; }
    .cart-table { max-height: 300px; overflow-y: auto; }
    .cart-table table { margin-bottom: 0; }
    .cart-table thead { position: sticky; top: 0; background: #fff; z-index: 1; }
    .cart-total { background: linear-gradient(135deg, #FAF5FF, #F5F3FF); padding: 16px; border-radius: 12px; }
    .cart-total hr { border-color: #E5E7EB; }
    .pos-cart .table-container { display: flex; flex-direction: column; height: 100%; }
</style>
@endpush
@section('content')
<div class="pos-container">
    <div class="pos-products">
        <div class="table-container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">Products</h5>
                <span class="text-secondary" style="font-size: 0.8rem;">{{ $products->count() }} items</span>
            </div>
            <input type="text" id="productSearch" class="form-control mb-3" placeholder="Search products by name...">
            <div class="product-grid" id="productGrid">
                @foreach($products as $p)
                <div class="product-card" data-id="{{ $p->id }}" data-name="{{ $p->product_name }}" data-price="{{ $p->selling_price }}" data-stock="{{ $p->quantity }}">
                    <div class="name">{{ $p->product_name }}</div>
                    <div class="price">${{ number_format($p->selling_price, 2) }}</div>
                    <div class="stock">Stock: {{ $p->quantity }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="pos-cart">
        <div class="table-container">
            <h5 class="fw-bold mb-3"><i class="bi bi-cart3 text-primary me-2"></i> Shopping Cart</h5>
            <div class="cart-table">
                <table class="table table-sm" id="cartTable">
                    <thead><tr><th>Item</th><th>Qty</th><th>Total</th><th></th></tr></thead>
                    <tbody id="cartBody"></tbody>
                </table>
            </div>
            <div class="cart-total mt-3">
                <div class="d-flex justify-content-between mb-2"><span class="text-secondary">Subtotal:</span><span id="subtotal" class="fw-semibold">$0.00</span></div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="text-secondary" style="font-size:0.85rem;">Discount (%):</label>
                    <input type="number" id="discPercent" class="form-control form-control-sm" style="width:80px" value="0" min="0" max="100">
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="text-secondary" style="font-size:0.85rem;">Tax (%):</label>
                    <input type="number" id="taxPercent" class="form-control form-control-sm" style="width:80px" value="0" min="0" max="100">
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5"><span>Grand Total:</span><span id="grandTotal">$0.00</span></div>
            </div>
            <div class="mt-3">
                <input type="text" id="customerName" class="form-control mb-2" placeholder="Customer name (optional)">
                <select id="paymentMethod" class="form-select mb-2">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="transfer">Bank Transfer</option>
                </select>
                <button class="btn btn-primary w-100 py-2" id="checkoutBtn" disabled><i class="bi bi-check-circle me-1"></i> Complete Sale</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];
function addToCart(id, name, price, stock) {
    const existing = cart.find(c => c.product_id === id);
    if (existing) {
        if (existing.quantity >= stock) return alert('Insufficient stock!');
        existing.quantity++;
    } else {
        if (stock < 1) return alert('Out of stock!');
        cart.push({ product_id: id, name, unit_price: price, quantity: 1, stock });
    }
    renderCart();
}
function renderCart() {
    const tbody = document.getElementById('cartBody');
    tbody.innerHTML = '';
    let subtotal = 0;
    cart.forEach((c, i) => {
        const total = c.quantity * c.unit_price;
        subtotal += total;
        const row = document.createElement('tr');
        row.style.animation = 'fadeSlideUp 250ms cubic-bezier(0.05,0.7,0.1,1) both';
        row.style.animationDelay = (i * 30) + 'ms';
        row.innerHTML = `<td class="fw-medium">${c.name}</td>
            <td><input type="number" class="form-control form-control-sm qty-input" style="width:65px" value="${c.quantity}" min="1" max="${c.stock}" data-index="${i}"></td>
            <td class="fw-semibold" style="color:#7C3AED">$${c.unit_price.toFixed(2)}</td>
            <td class="fw-semibold">$${total.toFixed(2)}</td>
            <td><button class="btn btn-sm btn-outline-danger border-0 remove-item px-1" data-index="${i}" title="Remove">&times;</button></td>`;
        tbody.appendChild(row);
    });
    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
    calcTotal();
    document.getElementById('checkoutBtn').disabled = cart.length === 0;
    document.querySelectorAll('.qty-input').forEach(inp => {
        inp.addEventListener('change', function() {
            const idx = parseInt(this.dataset.index);
            cart[idx].quantity = parseInt(this.value) || 1;
            renderCart();
        });
    });
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            cart.splice(parseInt(this.dataset.index), 1);
            renderCart();
        });
    });
}
function calcTotal() {
    const subtotal = cart.reduce((sum, c) => sum + c.quantity * c.unit_price, 0);
    const discPct = parseFloat(document.getElementById('discPercent').value) || 0;
    const taxPct = parseFloat(document.getElementById('taxPercent').value) || 0;
    const discAmt = subtotal * discPct / 100;
    const taxAmt = subtotal * taxPct / 100;
    const grandTotal = subtotal - discAmt + taxAmt;
    document.getElementById('grandTotal').textContent = '$' + grandTotal.toFixed(2);
}
document.getElementById('discPercent').addEventListener('input', calcTotal);
document.getElementById('taxPercent').addEventListener('input', calcTotal);
document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('click', function() {
        addToCart(
            parseInt(this.dataset.id),
            this.dataset.name,
            parseFloat(this.dataset.price),
            parseInt(this.dataset.stock)
        );
        // Quick press feedback
        this.style.transform = 'scale(0.95)';
        setTimeout(() => { this.style.transform = ''; }, 150);
    });
});
document.getElementById('productSearch').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.product-card').forEach(c => {
        c.style.display = c.dataset.name.toLowerCase().includes(q) ? '' : 'none';
    });
});
document.getElementById('checkoutBtn').addEventListener('click', function() {
    if (cart.length === 0) return;
    const data = {
        _token: '{{ csrf_token() }}',
        customer_name: document.getElementById('customerName').value,
        payment_method: document.getElementById('paymentMethod').value,
        tax_percentage: parseFloat(document.getElementById('taxPercent').value) || 0,
        discount_percentage: parseFloat(document.getElementById('discPercent').value) || 0,
        items: cart.map(c => ({ product_id: c.product_id, quantity: c.quantity }))
    };
    this.disabled = true;
    this.textContent = 'Processing...';
    fetch('{{ route("sales.store") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            window.location.href = '/sales/' + res.sale.id + '/receipt';
        } else {
            alert(res.message || 'Sale failed');
            this.disabled = false;
            this.innerHTML = '<i class="bi bi-check-circle"></i> Complete Sale';
        }
    })
    .catch(err => { alert('Error processing sale'); this.disabled = false; this.innerHTML = '<i class="bi bi-check-circle"></i> Complete Sale'; });
});
</script>
@endpush
