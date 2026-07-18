@extends('dashboard')

@section('content')

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:4px;">
            <i class="fas fa-coffee" style="font-size:28px; color:#6f3200;"></i>
            <h1 style="font-size:28px; font-weight:700; color:#1a1a2e; margin:0;">Coffee Menu</h1>
            <span style="background:#f1f5f9; padding:2px 12px; border-radius:100px; font-size:13px; color:#64748b;">
                {{ $products->count() }} items
            </span>
        </div>
        <p style="color:#64748b; font-size:14px; margin:0;">Manage your coffee and beverage offerings</p>
    </div>
    <a href="/products/create" class="btn btn-primary" style="padding:12px 24px; border-radius:12px; background:#6f3200; color:white; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:600; transition:all 0.2s; border:none;">
        <i class="fas fa-plus"></i> Add New Coffee
    </a>
</div>

{{-- Search & Filter --}}
<div style="background:white; border-radius:16px; padding:16px 20px; border:1px solid #eef2f6; margin-bottom:24px; display:flex; gap:16px; flex-wrap:wrap; align-items:center;">
    <div style="flex:1; min-width:200px;">
        <div style="position:relative;">
            <i class="fas fa-search" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
            <input type="text" id="searchInput" placeholder="Search coffee..." 
                   style="width:100%; padding:10px 16px 10px 42px; border:2px solid #eef2f6; border-radius:10px; font-size:14px; outline:none; transition:border-color 0.2s;">
        </div>
    </div>
    <div style="display:flex; gap:8px;">
        <select id="stockFilter" style="padding:10px 16px; border:2px solid #eef2f6; border-radius:10px; font-size:14px; outline:none; background:white; cursor:pointer;">
            <option value="all">All Stock</option>
            <option value="low">Low Stock (≤ 5)</option>
            <option value="in">In Stock (> 0)</option>
            <option value="out">Out of Stock (0)</option>
        </select>
    </div>
</div>

{{-- Products Grid --}}
@if($products->isEmpty())
    <div style="background:white; border-radius:16px; padding:60px 20px; text-align:center; border:2px dashed #eef2f6;">
        <div style="font-size:64px; margin-bottom:16px;">☕</div>
        <h3 style="color:#1a1a2e; margin-bottom:8px;">No coffee items yet</h3>
        <p style="color:#64748b; margin-bottom:20px;">Start adding your coffee offerings to the menu</p>
        <a href="/products/create" class="btn btn-primary" style="padding:12px 24px; border-radius:12px; background:#6f3200; color:white; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:600; transition:all 0.2s;">
            <i class="fas fa-plus"></i> Add Your First Coffee
        </a>
    </div>
@else
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:20px;">
        @foreach($products as $product)
        <div class="product-card" style="background:white; border-radius:16px; border:1px solid #eef2f6; overflow:hidden; transition:all 0.3s; position:relative;" data-name="{{ strtolower($product->name) }}" data-stock="{{ $product->stock }}">
            {{-- Low Stock Badge --}}
            @if($product->stock <= 5 && $product->stock > 0)
                <div style="position:absolute; top:12px; right:12px; background:#fef3c7; color:#d97706; padding:4px 12px; border-radius:100px; font-size:11px; font-weight:600; z-index:1;">
                    Low Stock
                </div>
            @elseif($product->stock == 0)
                <div style="position:absolute; top:12px; right:12px; background:#fee2e2; color:#dc2626; padding:4px 12px; border-radius:100px; font-size:11px; font-weight:600; z-index:1;">
                    Out of Stock
                </div>
            @endif

            {{-- Image --}}
            <div style="height:200px; background:#f8f9fc; display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden;">
                @if($product->image)
                    <img src="/images/{{ $product->image }}" 
                         alt="{{ $product->name }}"
                         style="width:100%; height:100%; object-fit:cover;">
                @else
                    <div style="font-size:72px; opacity:0.3;">☕</div>
                @endif
            </div>

            {{-- Content --}}
            <div style="padding:20px;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                    <h3 style="font-size:16px; font-weight:600; color:#1a1a2e; margin:0;">{{ $product->name }}</h3>
                    <span style="font-size:18px; font-weight:700; color:#6f3200;">${{ number_format($product->price, 2) }}</span>
                </div>

                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <span style="font-size:13px; color:#64748b;">
                        <i class="fas fa-box" style="margin-right:4px;"></i>
                        Stock: <strong style="color:#1a1a2e;">{{ $product->stock }}</strong>
                    </span>
                </div>

                {{-- Actions --}}
                <div style="display:flex; gap:8px; border-top:1px solid #eef2f6; padding-top:16px;">
                    <a href="/products/{{ $product->id }}/edit" 
                       style="flex:1; padding:8px; border-radius:8px; background:#f1f5f9; color:#1a1a2e; text-decoration:none; text-align:center; font-size:13px; font-weight:500; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:6px;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="/products/{{ $product->id }}" method="POST" style="flex:1;" onsubmit="return confirm('Delete this coffee?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                style="width:100%; padding:8px; border-radius:8px; background:#fee2e2; color:#dc2626; border:none; font-size:13px; font-weight:500; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:6px;">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Pagination --}}
@if(method_exists($products, 'links'))
    <div style="margin-top:28px; display:flex; justify-content:center;">
        {{ $products->links() }}
    </div>
@endif

{{-- Search & Filter Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const stockFilter = document.getElementById('stockFilter');
    const productCards = document.querySelectorAll('.product-card');

    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const stockValue = stockFilter.value;

        productCards.forEach(card => {
            const name = card.dataset.name.toLowerCase();
            const stock = parseInt(card.dataset.stock);
            let show = true;

            // Search filter
            if (searchTerm && !name.includes(searchTerm)) {
                show = false;
            }

            // Stock filter
            if (stockValue === 'low' && stock > 5) {
                show = false;
            } else if (stockValue === 'in' && stock <= 0) {
                show = false;
            } else if (stockValue === 'out' && stock > 0) {
                show = false;
            }

            card.style.display = show ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterProducts);
    stockFilter.addEventListener('change', filterProducts);
});
</script>

<style>
    .product-card {
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border-color: #d4a574;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(111, 50, 0, 0.3);
    }
</style>

@endsection