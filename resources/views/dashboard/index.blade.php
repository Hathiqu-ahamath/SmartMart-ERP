@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .chart-container { position: relative; height: 280px; }
    .kpi-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
    .quick-stat-item { padding: 12px 0; border-bottom: 1px solid #F3F4F6; }
    .quick-stat-item:last-child { border-bottom: none; padding-bottom: 0; }
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stats-card d-flex align-items-center">
            <div class="kpi-icon me-3" style="background: linear-gradient(135deg, #7C3AED, #A78BFA); color: #fff;"><i class="bi bi-currency-dollar"></i></div>
            <div>
                <div class="value" style="font-size: 1.4rem;">${{ number_format($stats['today_revenue'], 2) }}</div>
                <div class="label">Today's Revenue</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card d-flex align-items-center">
            <div class="kpi-icon me-3" style="background: linear-gradient(135deg, #059669, #34D399); color: #fff;"><i class="bi bi-cart-check"></i></div>
            <div>
                <div class="value" style="font-size: 1.4rem;">{{ $stats['today_transactions'] }}</div>
                <div class="label">Today's Transactions</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card d-flex align-items-center">
            <div class="kpi-icon me-3" style="background: linear-gradient(135deg, #D97706, #FBBF24); color: #fff;"><i class="bi bi-box"></i></div>
            <div>
                <div class="value" style="font-size: 1.4rem;">{{ $stats['total_products'] }}</div>
                <div class="label">Total Products</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card d-flex align-items-center">
            <div class="kpi-icon me-3" style="background: linear-gradient(135deg, #DC2626, #F87171); color: #fff;"><i class="bi bi-exclamation-triangle"></i></div>
            <div>
                <div class="value" style="font-size: 1.4rem;">{{ $stats['low_stock_products'] }}</div>
                <div class="label">Low Stock Items</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="table-container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">Sales Trend (7 Days)</h5>
                <span class="badge bg-primary-bg text-primary px-3 py-2" style="background: #FAF5FF; color: #7C3AED; border-radius: 20px; font-size: 0.75rem; font-weight: 500;">{{ array_sum(array_column($salesTrend, 'revenue')) > 0 ? '$' . number_format(array_sum(array_column($salesTrend, 'revenue')), 2) . ' total' : 'No data' }}</span>
            </div>
            <div class="chart-container">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="table-container">
            <h5 class="fw-bold mb-3">Quick Stats</h5>
            <div class="quick-stat-item d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-secondary d-block">Expired Products</small>
                    <span class="fw-bold fs-5">{{ $stats['expired_products'] }}</span>
                </div>
                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2" style="border-radius: 20px;">{{ $stats['expired_products'] > 0 ? 'Action needed' : 'All clear' }}</span>
            </div>
            <div class="quick-stat-item d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-secondary d-block">Expiring Soon (30 days)</small>
                    <span class="fw-bold fs-5">{{ $stats['expiring_products'] }}</span>
                </div>
                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2" style="border-radius: 20px;">{{ $stats['expiring_products'] > 0 ? 'Review' : 'All good' }}</span>
            </div>
            <div class="quick-stat-item d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-secondary d-block">Pending POs</small>
                    <span class="fw-bold fs-5">{{ $stats['pending_pos'] }}</span>
                </div>
                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2" style="border-radius: 20px;">{{ $stats['pending_pos'] > 0 ? 'Approve' : 'None' }}</span>
            </div>
            <div class="quick-stat-item d-flex justify-content-between align-items-center" style="border-bottom: none; padding-bottom: 0;">
                <div>
                    <small class="text-secondary d-block">Categories</small>
                    <span class="fw-bold fs-5">{{ $stats['total_categories'] }}</span>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2" style="border-radius: 20px;">Active</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="table-container">
            <h5 class="fw-bold mb-3"><i class="bi bi-exclamation-circle text-danger me-2"></i> Low Stock Products</h5>
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead><tr><th>Product</th><th>Category</th><th>Qty</th><th>Reorder</th></tr></thead>
                    <tbody>
                        @forelse($lowStockProducts as $p)
                        <tr class="cursor-pointer">
                            <td class="fw-medium">{{ $p->product_name }}</td>
                            <td><span class="text-secondary">{{ $p->category->name ?? 'N/A' }}</span></td>
                            <td><span class="badge bg-danger bg-opacity-10 text-danger px-3">{{ $p->quantity }}</span></td>
                            <td>{{ $p->reorder_level }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-secondary py-4">No low stock items</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-container">
            <h5 class="fw-bold mb-3"><i class="bi bi-clock-history text-primary me-2"></i> Recent Sales</h5>
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead><tr><th>Invoice</th><th>Amount</th><th>Cashier</th><th>Time</th></tr></thead>
                    <tbody>
                        @forelse($recentSales as $s)
                        <tr class="cursor-pointer">
                            <td><code>{{ $s->invoice_number }}</code></td>
                            <td class="fw-semibold">${{ number_format($s->grand_total, 2) }}</td>
                            <td>{{ $s->user->name }}</td>
                            <td class="text-secondary">{{ $s->created_at->format('H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-secondary py-4">No sales yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const ctx = document.getElementById('salesTrendChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($salesTrend, 'date')) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode(array_column($salesTrend, 'revenue')) !!},
            borderColor: '#7C3AED',
            backgroundColor: 'rgba(124, 58, 237, 0.08)',
            borderWidth: 2,
            pointBackgroundColor: '#7C3AED',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { callback: v => '$' + v } },
            x: { grid: { display: false } }
        },
        interaction: { intersect: false, mode: 'index' }
    }
});
</script>
@endpush
