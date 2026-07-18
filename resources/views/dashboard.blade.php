<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>☕ Coffee Shop POS</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #f8f9fc;
            color: #1a1a2e;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: #ffffff;
            padding: 0 32px;
            height: 72px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eef2f6;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            text-decoration: none;
        }

        .navbar-brand span {
            background: #6f3200;
            color: white;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .navbar-links a {
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-links a:hover {
            background: #f1f5f9;
            color: #1a1a2e;
        }

        .navbar-links a.active {
            background: #6f3200;
            color: white;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 12px;
            color: #1a1a2e;
            font-weight: 500;
            font-size: 14px;
        }

        .navbar-user .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #6f3200;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-logout {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: #64748b;
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #dc2626;
        }

        /* ===== CONTAINER ===== */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px 32px;
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .page-title p {
            color: #64748b;
            font-size: 14px;
            margin-top: 4px;
        }

        .page-actions {
            display: flex;
            gap: 10px;
        }

        .page-actions .btn {
            padding: 10px 20px;
            border-radius: 12px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #6f3200;
            color: white;
        }

        .btn-primary:hover {
            background: #5c2d0e;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(111, 50, 0, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .btn-outline:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        /* ===== STATS GRID ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 22px 24px;
            border: 1px solid #eef2f6;
            transition: all 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.04);
            border-color: #d4a574;
        }

        .stat-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 14px;
        }

        .stat-card .icon.blue { background: #e0f2fe; color: #0284c7; }
        .stat-card .icon.green { background: #d1fae5; color: #059669; }
        .stat-card .icon.orange { background: #fef3c7; color: #d97706; }
        .stat-card .icon.purple { background: #ede9fe; color: #7c3aed; }

        .stat-card .label {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .stat-card .value {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .stat-card .change {
            font-size: 12px;
            font-weight: 500;
            margin-top: 8px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 10px;
            border-radius: 100px;
        }

        .stat-card .change.up { background: #d1fae5; color: #059669; }
        .stat-card .change.down { background: #fee2e2; color: #dc2626; }

        /* ===== CHARTS GRID ===== */
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }

        .chart-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #eef2f6;
        }

        .chart-card .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-card .chart-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a2e;
        }

        .chart-card .chart-header .period {
            font-size: 12px;
            color: #64748b;
            background: #f1f5f9;
            padding: 4px 12px;
            border-radius: 100px;
        }

        .chart-container {
            position: relative;
            height: 260px;
        }

        /* ===== RECENT ACTIVITY ===== */
        .recent-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .recent-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #eef2f6;
        }

        .recent-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .recent-card .card-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a2e;
        }

        .recent-card .card-header a {
            font-size: 13px;
            color: #6f3200;
            text-decoration: none;
            font-weight: 500;
        }

        .recent-card .card-header a:hover { text-decoration: underline; }

        /* ===== TABLE ===== */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 12px 12px 0;
            border-bottom: 1px solid #eef2f6;
        }

        table td {
            padding: 12px 12px 12px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #1a1a2e;
        }

        table tr:last-child td { border-bottom: none; }

        .badge {
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge.success { background: #d1fae5; color: #059669; }
        .badge.warning { background: #fef3c7; color: #d97706; }
        .badge.danger { background: #fee2e2; color: #dc2626; }

        /* ===== ACTIVITY LIST ===== */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px;
            border-radius: 12px;
            background: #f8f9fc;
            transition: all 0.2s;
        }

        .activity-item:hover { background: #f1f5f9; }

        .activity-item .icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .activity-item .icon.orange { background: #fef3c7; color: #d97706; }
        .activity-item .icon.green { background: #d1fae5; color: #059669; }
        .activity-item .icon.blue { background: #e0f2fe; color: #0284c7; }
        .activity-item .icon.red { background: #fee2e2; color: #dc2626; }

        .activity-item .content {
            flex: 1;
        }

        .activity-item .content .title {
            font-size: 14px;
            font-weight: 500;
            color: #1a1a2e;
        }

        .activity-item .content .time {
            font-size: 12px;
            color: #94a3b8;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .charts-grid { grid-template-columns: 1fr; }
            .recent-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .navbar { padding: 0 16px; flex-wrap: wrap; height: auto; gap: 10px; padding: 12px 16px; }
            .navbar-links { flex-wrap: wrap; gap: 4px; }
            .navbar-links a { font-size: 12px; padding: 6px 12px; }
            .container { padding: 16px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
            .stats-grid { grid-template-columns: 1fr; }
            .stat-card .value { font-size: 22px; }
            .charts-grid { grid-template-columns: 1fr; }
            .recent-grid { grid-template-columns: 1fr; }
            .page-title h1 { font-size: 22px; }
        }
    </style>
</head>
<body>

{{-- ===== NAVBAR ===== --}}
<nav class="navbar">
    <a href="/" class="navbar-brand">
        ☕ Coffee Shop
        <span>POS</span>
    </a>

    <div class="navbar-links">
        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="/sales/create" class="{{ request()->is('sales/create') ? 'active' : '' }}">
            <i class="fas fa-cash-register"></i> POS
        </a>
        <a href="/sales" class="{{ request()->is('sales') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i> Sales
        </a>
        @if(auth()->user()->role === 'admin')
            <a href="/products" class="{{ request()->is('products*') ? 'active' : '' }}">
                <i class="fas fa-coffee"></i> Menu
            </a>
        @endif

        <div class="navbar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            {{ auth()->user()->name }}
        </div>

        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</nav>

{{-- ===== DASHBOARD CONTENT ===== --}}
@if(request()->is('/'))
<div class="container">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-title">
            <h1>👋 Welcome back, {{ auth()->user()->name }}!</h1>
            <p>Here's what's happening with your coffee shop today</p>
        </div>
        <div class="page-actions">
            <a href="/sales/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Sale
            </a>
            <a href="/sales" class="btn btn-outline">
                <i class="fas fa-chart-bar"></i> Reports
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon blue"><i class="fas fa-dollar-sign"></i></div>
            <div class="label">Today's Revenue</div>
            <div class="value">${{ number_format(\App\Models\Sale::whereDate('created_at', today())->sum('total_amount'), 2) }}</div>
            <div class="change up"><i class="fas fa-arrow-up"></i> +12.5%</div>
        </div>

        <div class="stat-card">
            <div class="icon green"><i class="fas fa-shopping-cart"></i></div>
            <div class="label">Today's Orders</div>
            <div class="value">{{ \App\Models\Sale::whereDate('created_at', today())->count() }}</div>
            <div class="change up"><i class="fas fa-arrow-up"></i> +8.3%</div>
        </div>

        <div class="stat-card">
            <div class="icon orange"><i class="fas fa-coffee"></i></div>
            <div class="label">Total Products</div>
            <div class="value">{{ \App\Models\Product::count() }}</div>
            <div class="change up"><i class="fas fa-arrow-up"></i> +3 new</div>
        </div>

        <div class="stat-card">
            <div class="icon purple"><i class="fas fa-users"></i></div>
            <div class="label">Total Staff</div>
            <div class="value">{{ \App\Models\User::count() }}</div>
            <div class="change down"><i class="fas fa-arrow-down"></i> -2.1%</div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="charts-grid">
        {{-- Revenue Chart --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-line" style="color:#6f3200;"></i> Revenue Overview</h3>
                <span class="period">Last 7 days</span>
            </div>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Sales Distribution --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-pie" style="color:#6f3200;"></i> Sales Overview</h3>
                <span class="period">This month</span>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="recent-grid">
        {{-- Recent Sales --}}
        <div class="recent-card">
            <div class="card-header">
                <h3><i class="fas fa-clock" style="color:#6f3200;"></i> Recent Sales</h3>
                <a href="/sales">View All →</a>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recentSales = \App\Models\Sale::latest()->take(5)->get();
                        @endphp
                        @forelse($recentSales as $sale)
                            <tr>
                                <td><strong>#{{ $sale->id }}</strong></td>
                                <td>${{ number_format($sale->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge success">Completed</span>
                                </td>
                                <td style="font-size:12px; color:#64748b;">
                                    {{ $sale->created_at->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center; color:#94a3b8; padding:20px;">
                                    No sales yet today
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Activity Feed --}}
        <div class="recent-card">
            <div class="card-header">
                <h3><i class="fas fa-bolt" style="color:#6f3200;"></i> Activity Feed</h3>
            </div>
            <div class="activity-list">
                @php
                    $activities = \App\Models\Sale::latest()->take(5)->get();
                @endphp
                @forelse($activities as $activity)
                    <div class="activity-item">
                        <div class="icon green"><i class="fas fa-receipt"></i></div>
                        <div class="content">
                            <div class="title">New sale #{{ $activity->id }}</div>
                            <div class="time">${{ number_format($activity->total_amount, 2) }} • {{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; color:#94a3b8; padding:20px;">
                        No recent activity
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endif

{{-- ===== OTHER PAGES ===== --}}
@if(!request()->is('/'))
<div class="container" style="max-width:1400px; margin:0 auto; padding:28px 32px;">
    @if(session('success'))
        <div style="background:#d1fae5; border:1px solid #a7f3d0; color:#065f46; padding:14px 20px; border-radius:12px; margin-bottom:20px; font-size:14px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; padding:14px 20px; border-radius:12px; margin-bottom:20px; font-size:14px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @yield('content')
</div>
@endif

{{-- ===== CHARTS JAVASCRIPT ===== --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const ctx1 = document.getElementById('revenueChart')?.getContext('2d');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Revenue',
                    data: @php
                        $revenueData = [];
                        for ($i = 6; $i >= 0; $i--) {
                            $date = now()->subDays($i);
                            $revenueData[] = \App\Models\Sale::whereDate('created_at', $date)->sum('total_amount');
                        }
                        echo json_encode($revenueData);
                    @endphp,
                    borderColor: '#6f3200',
                    backgroundColor: 'rgba(111, 50, 0, 0.05)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#6f3200',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: {
                            callback: function(value) { return '$' + value.toFixed(0); }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // Sales Chart
    const ctx2 = document.getElementById('salesChart')?.getContext('2d');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: @php
                    $salesData = \App\Models\Sale::latest()->take(5)->get();
                    $labels = [];
                    $data = [];
                    $colors = ['#6f3200', '#d4a574', '#8b4513', '#a0522d', '#cd853f'];
                    foreach ($salesData as $index => $sale) {
                        $labels[] = 'Sale #' . $sale->id;
                        $data[] = $sale->total_amount;
                    }
                    if (empty($labels)) {
                        $labels = ['No Sales Yet'];
                        $data = [1];
                    }
                    echo json_encode($labels);
                @endphp,
                datasets: [{
                    data: @php
                        echo json_encode($data);
                    @endphp,
                    backgroundColor: ['#6f3200', '#d4a574', '#8b4513', '#a0522d', '#cd853f'],
                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 16,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }
});
</script>

</body>
</html>