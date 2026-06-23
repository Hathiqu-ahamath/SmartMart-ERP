@extends('layouts.app')
@section('title', 'Monthly Sales Report')
@section('page-title', 'Monthly Sales Report')
@section('content')
<div class="table-container mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-auto">
            <label class="form-label">Month</label>
            <select name="month" class="form-select">
                @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
                @endfor
            </select>
        </div>
        <div class="col-auto">
            <label class="form-label">Year</label>
            <select name="year" class="form-select">
                @for($y = date('Y') - 2; $y <= date('Y'); $y++)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> View</button>
        </div>
    </form>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stats-card text-center">
            <div class="value text-primary">${{ number_format($totalRevenue, 2) }}</div>
            <div class="label">Total Revenue</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card text-center">
            <div class="value text-success">{{ $totalTransactions }}</div>
            <div class="label">Transactions</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card text-center">
            <div class="value text-info">${{ number_format($totalProfit, 2) }}</div>
            <div class="label">Total Profit</div>
        </div>
    </div>
</div>
<div class="row g-3">
    <div class="col-md-8">
        <div class="table-container">
            <h5 class="fw-bold mb-3">Daily Breakdown</h5>
            <div style="height: 250px;">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="table-container">
            <h5 class="fw-bold mb-3">Transactions</h5>
            <table class="table table-sm">
                <thead><tr><th>Date</th><th>Revenue</th><th>Count</th></tr></thead>
                <tbody>
                    @foreach($dailyBreakdown as $d)
                    <tr>
                        <td>{{ $d['date'] }}</td>
                        <td>${{ number_format($d['revenue'], 2) }}</td>
                        <td>{{ $d['transactions'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const ctx = document.getElementById('monthlyChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($dailyBreakdown->toArray(), 'date')) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode(array_column($dailyBreakdown->toArray(), 'revenue')) !!},
            backgroundColor: '#3498db',
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { callback: v => '$' + v } } }
    }
});
</script>
@endpush
