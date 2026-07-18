@extends('dashboard')

@section('content')

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:4px;">
            <i class="fas fa-receipt" style="font-size:28px; color:#6f3200;"></i>
            <h1 style="font-size:28px; font-weight:700; color:#1a1a2e; margin:0;">Sales History</h1>
            <span style="background:#f1f5f9; padding:2px 12px; border-radius:100px; font-size:13px; color:#64748b;">
                {{ $sales->count() }} orders
            </span>
        </div>
        <p style="color:#64748b; font-size:14px; margin:0;">View all completed orders and transactions</p>
    </div>
    <a href="/sales/create" class="btn btn-primary" style="padding:12px 24px; border-radius:12px; background:#6f3200; color:white; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:600; transition:all 0.2s; border:none;">
        <i class="fas fa-plus"></i> New Sale
    </a>
</div>

{{-- Stats Row --}}
<div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:16px; margin-bottom:28px;">
    <div style="background:white; border-radius:12px; padding:16px 20px; border:1px solid #eef2f6;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:#e0f2fe; width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#0284c7;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#64748b; font-weight:500;">Total Orders</div>
                <div style="font-size:20px; font-weight:700; color:#1a1a2e;">{{ $sales->count() }}</div>
            </div>
        </div>
    </div>
    <div style="background:white; border-radius:12px; padding:16px 20px; border:1px solid #eef2f6;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:#d1fae5; width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#059669;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#64748b; font-weight:500;">Total Revenue</div>
                <div style="font-size:20px; font-weight:700; color:#1a1a2e;">
                    ${{ number_format($sales->sum('total_amount'), 2) }}
                </div>
            </div>
        </div>
    </div>
    <div style="background:white; border-radius:12px; padding:16px 20px; border:1px solid #eef2f6;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:#fef3c7; width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#d97706;">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#64748b; font-weight:500;">Today's Orders</div>
                <div style="font-size:20px; font-weight:700; color:#1a1a2e;">
                    {{ \App\Models\Sale::whereDate('created_at', today())->count() }}
                </div>
            </div>
        </div>
    </div>
    <div style="background:white; border-radius:12px; padding:16px 20px; border:1px solid #eef2f6;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="background:#ede9fe; width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#7c3aed;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <div style="font-size:12px; color:#64748b; font-weight:500;">Avg Order Value</div>
                <div style="font-size:20px; font-weight:700; color:#1a1a2e;">
                    ${{ number_format($sales->count() > 0 ? $sales->avg('total_amount') : 0, 2) }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Search & Filter --}}
<div style="background:white; border-radius:16px; padding:16px 20px; border:1px solid #eef2f6; margin-bottom:24px; display:flex; gap:16px; flex-wrap:wrap; align-items:center;">
    <div style="flex:1; min-width:200px;">
        <div style="position:relative;">
            <i class="fas fa-search" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
            <input type="text" id="searchInput" placeholder="Search by order #..." 
                   style="width:100%; padding:10px 16px 10px 42px; border:2px solid #eef2f6; border-radius:10px; font-size:14px; outline:none; transition:border-color 0.2s;">
        </div>
    </div>
    <div style="display:flex; gap:8px;">
        <select id="dateFilter" style="padding:10px 16px; border:2px solid #eef2f6; border-radius:10px; font-size:14px; outline:none; background:white; cursor:pointer;">
            <option value="all">All Time</option>
            <option value="today">Today</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
        </select>
    </div>
</div>

{{-- Sales Table --}}
<div style="background:white; border-radius:16px; border:1px solid #eef2f6; overflow:hidden;">
    @if($sales->isEmpty())
        <div style="padding:60px 20px; text-align:center;">
            <div style="font-size:64px; margin-bottom:16px;">📋</div>
            <h3 style="color:#1a1a2e; margin-bottom:8px;">No sales yet</h3>
            <p style="color:#64748b; margin-bottom:20px;">Start making sales through the POS system</p>
            <a href="/sales/create" class="btn btn-primary" style="padding:12px 24px; border-radius:12px; background:#6f3200; color:white; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:600; transition:all 0.2s;">
                <i class="fas fa-plus"></i> New Sale
            </a>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8f9fc; border-bottom:2px solid #eef2f6;">
                        <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">
                            <i class="fas fa-hashtag"></i> Order #
                        </th>
                        <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">
                            <i class="fas fa-dollar-sign"></i> Amount
                        </th>
                        <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">
                            <i class="fas fa-calendar"></i> Date
                        </th>
                        <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">
                            <i class="fas fa-clock"></i> Time
                        </th>
                        <th style="padding:14px 20px; text-align:center; font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">
                            <i class="fas fa-cog"></i> Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr style="border-bottom:1px solid #f1f5f9; transition:background 0.2s;" class="sale-row" data-id="{{ $sale->id }}">
                        <td style="padding:14px 20px; font-size:14px; font-weight:600; color:#1a1a2e;">
                            #{{ $sale->id }}
                        </td>
                        <td style="padding:14px 20px; font-size:14px; font-weight:600; color:#6f3200;">
                            ${{ number_format($sale->total_amount, 2) }}
                        </td>
                        <td style="padding:14px 20px; font-size:14px; color:#1a1a2e;">
                            {{ $sale->created_at->format('d M Y') }}
                        </td>
                        <td style="padding:14px 20px; font-size:14px; color:#64748b;">
                            {{ $sale->created_at->format('h:i A') }}
                        </td>
                        <td style="padding:14px 20px; text-align:center;">
                            <a href="/sales/{{ $sale->id }}" 
                               style="padding:6px 16px; border-radius:8px; background:#6f3200; color:white; text-decoration:none; font-size:12px; font-weight:500; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; border:none;">
                                <i class="fas fa-receipt"></i> View Receipt
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- Pagination --}}
@if(method_exists($sales, 'links'))
    <div style="margin-top:28px; display:flex; justify-content:center;">
        {{ $sales->links() }}
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const rows = document.querySelectorAll('.sale-row');

    function filterSales() {
        const searchTerm = searchInput.value.toLowerCase();
        const dateValue = dateFilter.value;
        const today = new Date();
        const weekAgo = new Date(today);
        weekAgo.setDate(weekAgo.getDate() - 7);
        const monthAgo = new Date(today);
        monthAgo.setMonth(monthAgo.getMonth() - 1);

        rows.forEach(row => {
            const id = row.dataset.id;
            const dateText = row.querySelector('td:nth-child(3)').textContent;
            const rowDate = new Date(dateText);
            let show = true;

            // Search filter
            if (searchTerm && !id.includes(searchTerm)) {
                show = false;
            }

            // Date filter
            if (dateValue === 'today') {
                if (rowDate.toDateString() !== today.toDateString()) show = false;
            } else if (dateValue === 'week') {
                if (rowDate < weekAgo) show = false;
            } else if (dateValue === 'month') {
                if (rowDate < monthAgo) show = false;
            }

            row.style.display = show ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterSales);
    dateFilter.addEventListener('change', filterSales);
});
</script>

<style>
    .sale-row:hover {
        background: #f8f9fc;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(111, 50, 0, 0.3);
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        .page-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 16px !important;
        }
    }
</style>

@endsection