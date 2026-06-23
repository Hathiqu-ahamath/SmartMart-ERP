<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - {{ $sale->invoice_number }}</title>
    <style>
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 300px; margin: 20px auto; }
        .header { text-align: center; border-bottom: 1px dashed #000; padding-bottom: 10px; margin-bottom: 10px; }
        .header h3 { margin: 0; font-size: 16px; }
        .items { width: 100%; }
        .items td { padding: 3px 0; }
        .total { border-top: 1px dashed #000; padding-top: 5px; margin-top: 5px; text-align: right; font-weight: bold; }
        .footer { text-align: center; border-top: 1px dashed #000; padding-top: 10px; margin-top: 10px; font-size: 10px; }
        .text-right { text-align: right; }
        @media print { body { margin: 0; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <h3>SmartMart ERP</h3>
        <small>Supermarket Management System</small>
        <p>
            Invoice: {{ $sale->invoice_number }}<br>
            Date: {{ $sale->created_at->format('d M Y H:i') }}<br>
            Cashier: {{ $sale->user->name ?? 'N/A' }}<br>
            @if($sale->customer_name)Customer: {{ $sale->customer_name }}@endif
        </p>
    </div>
    <table class="items">
        <thead><tr><th>Item</th><th>Qty</th><th class="text-right">Price</th></tr></thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="text-right">${{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="total">
        <p>Subtotal: ${{ number_format($sale->subtotal, 2) }}</p>
        @if($sale->discount_amount > 0)<p>Discount: -${{ number_format($sale->discount_amount, 2) }}</p>@endif
        @if($sale->tax_amount > 0)<p>Tax: ${{ number_format($sale->tax_amount, 2) }}</p>@endif
        <p>TOTAL: ${{ number_format($sale->grand_total, 2) }}</p>
        <p>Paid via: {{ ucfirst($sale->payment_method) }}</p>
    </div>
    <div class="footer">
        <p>Thank you for shopping at SmartMart!</p>
        <p>Items sold are not returnable</p>
    </div>
    <div class="text-center no-print" style="margin-top: 20px;">
        <button onclick="window.print()" class="btn" style="background:#7C3AED;color:#fff;border:none;padding:10px 24px;border-radius:8px;font-weight:500;cursor:pointer;">Print Receipt</button>
        <a href="{{ route('sales.pos') }}" class="btn" style="background:#6B7280;color:#fff;border:none;padding:10px 24px;border-radius:8px;font-weight:500;text-decoration:none;display:inline-block;margin-left:8px;">New Sale</a>
    </div>
</body>
</html>
