@extends('dashboard')

@section('content')

<style>
    .invoice-box {
        max-width: 550px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        padding: 40px;
        border: 1px solid #eef2f6;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 24px;
    }

    .invoice-logo {
        font-size: 48px;
        margin-bottom: 6px;
    }

    .invoice-shop-name {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
    }

    .invoice-sub {
        font-size: 13px;
        color: #64748b;
        margin-top: 2px;
    }

    .invoice-divider {
        border-top: 2px dashed #eef2f6;
        margin: 16px 0;
    }

    .invoice-info {
        font-size: 14px;
        color: #1a1a2e;
        margin-bottom: 4px;
        display: flex;
        justify-content: space-between;
    }

    .invoice-info-label {
        color: #64748b;
        font-weight: 400;
    }

    .invoice-info-value {
        font-weight: 500;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin: 8px 0;
    }

    .invoice-table th {
        background: #f8f9fc;
        color: #1a1a2e;
        padding: 10px 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 2px solid #eef2f6;
    }

    .invoice-table td {
        padding: 10px 12px;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
    }

    .invoice-table tr:last-child td {
        border-bottom: none;
    }

    .invoice-total {
        display: flex;
        justify-content: space-between;
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        padding: 16px 0;
        border-top: 2px solid #eef2f6;
        margin-top: 8px;
    }

    .invoice-total-amount {
        color: #6f3200;
    }

    .invoice-thankyou {
        text-align: center;
        color: #64748b;
        font-size: 14px;
        margin-top: 12px;
        padding-top: 16px;
        border-top: 1px solid #eef2f6;
    }

    .invoice-thankyou span {
        color: #6f3200;
        font-weight: 600;
    }

    .invoice-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 24px;
        flex-wrap: wrap;
    }

    .invoice-actions .btn {
        padding: 10px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-back {
        background: #f1f5f9;
        color: #1a1a2e;
    }

    .btn-back:hover {
        background: #e2e8f0;
    }

    .btn-print {
        background: #6f3200;
        color: white;
    }

    .btn-print:hover {
        background: #5c2d0e;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(111, 50, 0, 0.3);
    }

    .btn-new {
        background: #d1fae5;
        color: #059669;
    }

    .btn-new:hover {
        background: #a7f3d0;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        background: #d1fae5;
        color: #059669;
    }

    @media print {
        .navbar, .invoice-actions, .btn, .no-print {
            display: none !important;
        }
        .invoice-box {
            border: none !important;
            box-shadow: none !important;
            padding: 20px !important;
        }
        body {
            background: white !important;
        }
    }

    @media (max-width: 768px) {
        .invoice-box {
            padding: 24px;
            margin: 0 10px;
        }
        .invoice-actions {
            flex-direction: column;
        }
        .invoice-actions .btn {
            justify-content: center;
        }
    }
</style>

<div class="invoice-box" id="receipt">
    <div class="invoice-header">
        <div class="invoice-logo">☕</div>
        <div class="invoice-shop-name">Coffee Shop</div>
        <div class="invoice-sub">Premium Coffee & More</div>
    </div>

    <div class="invoice-divider"></div>

    <div class="invoice-info">
        <span class="invoice-info-label">Order #</span>
        <span class="invoice-info-value">#{{ $sale->id }}</span>
    </div>
    <div class="invoice-info">
        <span class="invoice-info-label">Date</span>
        <span class="invoice-info-value">{{ $sale->created_at->format('d M Y') }}</span>
    </div>
    <div class="invoice-info">
        <span class="invoice-info-label">Time</span>
        <span class="invoice-info-value">{{ $sale->created_at->format('h:i A') }}</span>
    </div>
    <div class="invoice-info" style="margin-top:4px;">
        <span class="invoice-info-label">Status</span>
        <span class="status-badge">✓ Completed</span>
    </div>

    <div class="invoice-divider"></div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Item</th>
                <th style="text-align:center;">Qty</th>
                <th style="text-align:right;">Price</th>
                <th style="text-align:right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td style="text-align:center;">{{ $item->quantity }}</td>
                <td style="text-align:right;">${{ number_format($item->price, 2) }}</td>
                <td style="text-align:right;">${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="invoice-total">
        <span>TOTAL</span>
        <span class="invoice-total-amount">${{ number_format($sale->total_amount, 2) }}</span>
    </div>

    <div class="invoice-thankyou">
        ☕ Thank you for your order!<br>
        <span>We hope to see you again soon</span>
    </div>
</div>

{{-- Actions --}}
<div class="invoice-actions no-print">
    <a href="/sales" class="btn btn-back">
        <i class="fas fa-arrow-left"></i> Back to Sales
    </a>
    <a href="/sales/create" class="btn btn-new">
        <i class="fas fa-plus"></i> New Order
    </a>
</div>

<script>
    function printReceipt() {
        window.print();
    }
</script>

@endsection