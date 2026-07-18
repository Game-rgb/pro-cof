@extends('dashboard')

@section('content')

<style>
    .pos-container {
        display: flex;
        gap: 24px;
        align-items: flex-start;
        min-height: calc(100vh - 160px);
    }

    .products-grid {
        flex: 2;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .coffee-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 2px solid #eef2f6;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .coffee-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        border-color: #d4a574;
    }

    .coffee-card.selected {
        border-color: #6f3200;
        box-shadow: 0 8px 24px rgba(111, 50, 0, 0.15);
        background: #fff8f2;
    }

    .coffee-card img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        background: #f8f9fc;
    }

    .coffee-card-no-image {
        width: 100%;
        height: 140px;
        background: #f8f9fc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: #d4a574;
    }

    .coffee-card-body {
        padding: 14px 16px;
    }

    .coffee-card-name {
        font-weight: 600;
        font-size: 15px;
        color: #1a1a2e;
        margin-bottom: 4px;
    }

    .coffee-card-price {
        color: #6f3200;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .coffee-card-qty {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .qty-display {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a2e;
    }

    .qty-display span {
        background: #6f3200;
        color: white;
        padding: 0 10px;
        border-radius: 4px;
        font-size: 14px;
        min-width: 24px;
        display: inline-block;
        text-align: center;
    }

    .btn-qty {
        background: #f1f5f9;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 18px;
        cursor: pointer;
        color: #1a1a2e;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-qty:hover {
        background: #6f3200;
        color: white;
    }

    .btn-qty.minus:hover {
        background: #dc2626;
    }

    /* Order Summary */
    .order-summary {
        flex: 0 0 380px;
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #eef2f6;
        position: sticky;
        top: 100px;
        max-height: calc(100vh - 160px);
        display: flex;
        flex-direction: column;
    }

    .order-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .order-count {
        background: #6f3200;
        color: white;
        padding: 2px 12px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
    }

    .order-items-wrapper {
        flex: 1;
        overflow-y: auto;
        margin-bottom: 16px;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item-info {
        flex: 1;
    }

    .order-item-name {
        font-size: 14px;
        font-weight: 500;
        color: #1a1a2e;
    }

    .order-item-qty {
        font-size: 12px;
        color: #64748b;
    }

    .order-item-price {
        font-size: 14px;
        font-weight: 600;
        color: #6f3200;
    }

    .order-empty {
        color: #94a3b8;
        font-size: 14px;
        text-align: center;
        padding: 40px 0;
    }

    .order-empty-icon {
        font-size: 48px;
        margin-bottom: 12px;
        display: block;
    }

    .order-total {
        display: flex;
        justify-content: space-between;
        padding: 16px 0;
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
        border-top: 2px solid #f1f5f9;
    }

    .order-total-amount {
        color: #6f3200;
    }

    .btn-order {
        width: 100%;
        padding: 14px;
        background: #6f3200;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-order:hover:not(:disabled) {
        background: #5c2d0e;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(111, 50, 0, 0.3);
    }

    .btn-order:disabled {
        background: #e2e8f0;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .btn-clear {
        width: 100%;
        padding: 10px;
        background: transparent;
        color: #dc2626;
        border: 1px solid #fee2e2;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 8px;
    }

    .btn-clear:hover {
        background: #fee2e2;
    }

    @media (max-width: 1200px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .order-summary {
            flex: 0 0 320px;
        }
    }

    @media (max-width: 768px) {
        .pos-container {
            flex-direction: column;
        }
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .order-summary {
            flex: 1;
            width: 100%;
            position: static;
            max-height: none;
        }
    }
</style>

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:4px;">
            <i class="fas fa-cash-register" style="font-size:28px; color:#6f3200;"></i>
            <h1 style="font-size:28px; font-weight:700; color:#1a1a2e; margin:0;">Point of Sale</h1>
            <span style="background:#d1fae5; padding:2px 12px; border-radius:100px; font-size:13px; color:#059669;">
                <i class="fas fa-sparkles"></i> New Order
            </span>
        </div>
        <p style="color:#64748b; font-size:14px; margin:0;">Select items and complete the order</p>
    </div>
    <a href="/sales" class="btn btn-outline" style="padding:10px 20px; border-radius:12px; background:transparent; color:#64748b; border:1px solid #e2e8f0; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:500; transition:all 0.2s;">
        <i class="fas fa-arrow-left"></i> Back to Sales
    </a>
</div>

<form action="/sales" method="POST" id="pos-form">
@csrf

<div class="pos-container">

    {{-- LEFT: Products --}}
    <div class="products-grid">
        @foreach($products as $product)
        <div class="coffee-card"
             id="card-{{ $product->id }}"
             onclick="addQty({{ $product->id }}, {{ $product->price }}, '{{ addslashes($product->name) }}')">

            @if($product->image)
                <img src="/images/{{ $product->image }}" alt="{{ $product->name }}">
            @else
                <div class="coffee-card-no-image">☕</div>
            @endif

            <div class="coffee-card-body">
                <div class="coffee-card-name">{{ $product->name }}</div>
                <div class="coffee-card-price">${{ number_format($product->price, 2) }}</div>

                <div class="coffee-card-qty">
                    <span class="qty-display">
                        Qty: <span id="qty-{{ $product->id }}">0</span>
                    </span>
                    <div style="display:flex; gap:6px;">
                        <button type="button" class="btn-qty minus"
                                onclick="event.stopPropagation(); minusQty({{ $product->id }}, {{ $product->price }}, '{{ addslashes($product->name) }}')">
                            −
                        </button>
                        <button type="button" class="btn-qty"
                                onclick="event.stopPropagation(); addQty({{ $product->id }}, {{ $product->price }}, '{{ addslashes($product->name) }}')">
                            +
                        </button>
                    </div>
                </div>
            </div>

            <input type="hidden"
                   name="quantities[{{ $product->id }}]"
                   id="input-{{ $product->id }}"
                   value="0">
        </div>
        @endforeach
    </div>

    {{-- RIGHT: Order Summary --}}
    <div class="order-summary">
        <div class="order-title">
            🧾 Order Summary
            <span class="order-count" id="itemCount">0</span>
        </div>

        <div class="order-items-wrapper" id="orderItems">
            <div class="order-empty">
                <span class="order-empty-icon">🛒</span>
                No items added yet<br>
                <span style="font-size:12px; color:#94a3b8;">Click on any coffee to add</span>
            </div>
        </div>

        <div class="order-total">
            <span>Total:</span>
            <span class="order-total-amount" id="orderTotal">$0.00</span>
        </div>

        <button type="submit" class="btn-order" id="orderBtn" disabled>
            <i class="fas fa-check-circle"></i> Complete Order
        </button>

        <button type="button" class="btn-clear" onclick="clearOrder()">
            <i class="fas fa-trash"></i> Clear All Items
        </button>
    </div>

</div>
</form>

<script>
    let orderItems = {};
    let grandTotal = 0;

    function addQty(id, price, name) {
        if (!orderItems[id]) {
            orderItems[id] = { name: name, price: price, qty: 0 };
        }
        orderItems[id].qty++;
        updateDisplay(id);
    }

    function minusQty(id, price, name) {
        if (!orderItems[id] || orderItems[id].qty === 0) return;
        orderItems[id].qty--;
        updateDisplay(id);
    }

    function updateDisplay(id) {
        let qty = orderItems[id].qty;
        document.getElementById('qty-' + id).innerText = qty;
        document.getElementById('input-' + id).value = qty;

        let card = document.getElementById('card-' + id);
        if (qty > 0) {
            card.classList.add('selected');
        } else {
            card.classList.remove('selected');
        }
        updateSummary();
    }

    function updateSummary() {
        let html = '';
        grandTotal = 0;
        let totalItems = 0;

        for (let id in orderItems) {
            let item = orderItems[id];
            if (item.qty > 0) {
                totalItems += item.qty;
                let subtotal = item.price * item.qty;
                grandTotal += subtotal;
                html += `
                    <div class="order-item">
                        <div class="order-item-info">
                            <div class="order-item-name">${item.name}</div>
                            <div class="order-item-qty">×${item.qty}</div>
                        </div>
                        <div class="order-item-price">$${subtotal.toFixed(2)}</div>
                    </div>
                `;
            }
        }

        document.getElementById('orderItems').innerHTML = 
            html || `<div class="order-empty">
                        <span class="order-empty-icon">🛒</span>
                        No items added yet<br>
                        <span style="font-size:12px; color:#94a3b8;">Click on any coffee to add</span>
                    </div>`;

        document.getElementById('orderTotal').innerText = '$' + grandTotal.toFixed(2);
        document.getElementById('itemCount').innerText = totalItems;
        document.getElementById('orderBtn').disabled = totalItems === 0;
    }

    function clearOrder() {
        if (confirm('Clear all items from order?')) {
            for (let id in orderItems) {
                orderItems[id].qty = 0;
                updateDisplay(id);
            }
        }
    }
</script>

@endsection