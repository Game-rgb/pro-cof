@extends('dashboard')

@section('content')

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:4px;">
            <i class="fas fa-edit" style="font-size:28px; color:#6f3200;"></i>
            <h1 style="font-size:28px; font-weight:700; color:#1a1a2e; margin:0;">Edit Coffee</h1>
            <span style="background:#f1f5f9; padding:2px 12px; border-radius:100px; font-size:13px; color:#64748b;">
                #{{ $product->id }}
            </span>
        </div>
        <p style="color:#64748b; font-size:14px; margin:0;">Update coffee details and inventory</p>
    </div>
    <a href="/products" class="btn btn-outline" style="padding:10px 20px; border-radius:12px; background:transparent; color:#64748b; border:1px solid #e2e8f0; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:500; transition:all 0.2s;">
        <i class="fas fa-arrow-left"></i> Back to Menu
    </a>
</div>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; max-width:1000px;">
    
    {{-- Edit Form --}}
    <div style="background:white; border-radius:16px; padding:32px; border:1px solid #eef2f6;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
            <div style="background:#fef3c7; width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#d97706;">
                <i class="fas fa-pen"></i>
            </div>
            <div>
                <h3 style="font-size:16px; font-weight:600; color:#1a1a2e; margin:0;">Coffee Details</h3>
                <p style="font-size:13px; color:#64748b; margin:0;">Edit the coffee information below</p>
            </div>
        </div>

        @if($errors->any())
            <div style="background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; padding:14px 18px; border-radius:12px; margin-bottom:24px; font-size:13px;">
                <div style="display:flex; align-items:center; gap:8px; font-weight:600; margin-bottom:6px;">
                    <i class="fas fa-exclamation-circle"></i> Please fix the following errors:
                </div>
                @foreach($errors->all() as $error)
                    <p style="margin:2px 0;">• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#1a1a2e; margin-bottom:6px;">
                    <i class="fas fa-coffee" style="color:#6f3200; margin-right:6px;"></i> Coffee Name
                </label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                       style="width:100%; padding:12px 16px; border:2px solid #eef2f6; border-radius:10px; font-size:14px; outline:none; transition:border-color 0.2s; background:#fafafa;"
                       placeholder="Enter coffee name" required>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:20px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#1a1a2e; margin-bottom:6px;">
                        <i class="fas fa-dollar-sign" style="color:#6f3200; margin-right:6px;"></i> Price ($)
                    </label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                           style="width:100%; padding:12px 16px; border:2px solid #eef2f6; border-radius:10px; font-size:14px; outline:none; transition:border-color 0.2s; background:#fafafa;"
                           placeholder="0.00" required min="0">
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#1a1a2e; margin-bottom:6px;">
                        <i class="fas fa-box" style="color:#6f3200; margin-right:6px;"></i> Stock
                    </label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                           style="width:100%; padding:12px 16px; border:2px solid #eef2f6; border-radius:10px; font-size:14px; outline:none; transition:border-color 0.2s; background:#fafafa;"
                           placeholder="0" required min="0">
                </div>
            </div>

            <div class="form-group" style="margin-bottom:24px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#1a1a2e; margin-bottom:6px;">
                    <i class="fas fa-image" style="color:#6f3200; margin-right:6px;"></i> Product Image
                </label>
                
                @if($product->image)
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px; background:#f8f9fc; padding:10px 14px; border-radius:10px;">
                        <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                             style="width:60px; height:60px; border-radius:8px; object-fit:cover; border:2px solid #eef2f6;">
                        <div>
                            <div style="font-size:13px; font-weight:500; color:#1a1a2e;">Current Image</div>
                            <div style="font-size:12px; color:#64748b;">{{ $product->image }}</div>
                        </div>
                    </div>
                @endif

                <input type="file" name="image" accept="image/*"
                       style="width:100%; padding:10px; border:2px dashed #eef2f6; border-radius:10px; font-size:14px; outline:none; transition:border-color 0.2s; cursor:pointer; background:#fafafa;">
                <small style="color:#94a3b8; font-size:12px; display:block; margin-top:6px;">
                    <i class="fas fa-info-circle"></i> Leave empty to keep current image. Max size: 2MB
                </small>
            </div>

            <div style="display:flex; gap:12px; border-top:1px solid #eef2f6; padding-top:20px;">
                <button type="submit" class="btn btn-primary" 
                        style="flex:1; padding:12px 24px; border-radius:12px; background:#6f3200; color:white; border:none; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                    <i class="fas fa-save"></i> Update Coffee
                </button>
                <a href="/products" class="btn btn-outline" 
                   style="flex:1; padding:12px 24px; border-radius:12px; background:transparent; color:#64748b; border:1px solid #e2e8f0; text-decoration:none; text-align:center; font-size:14px; font-weight:500; transition:all 0.2s; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    {{-- Product Preview Card --}}
    <div style="background:white; border-radius:16px; padding:32px; border:1px solid #eef2f6; height:fit-content; position:sticky; top:100px;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
            <div style="background:#e0f2fe; width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#0284c7;">
                <i class="fas fa-eye"></i>
            </div>
            <div>
                <h3 style="font-size:16px; font-weight:600; color:#1a1a2e; margin:0;">Preview</h3>
                <p style="font-size:13px; color:#64748b; margin:0;">Live product preview</p>
            </div>
        </div>

        <div style="background:#f8f9fc; border-radius:12px; padding:24px; text-align:center;">
            <div style="font-size:72px; margin-bottom:16px;">
                @if($product->image)
                    <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                         style="width:120px; height:120px; border-radius:12px; object-fit:cover; margin:0 auto;">
                @else
                    ☕
                @endif
            </div>
            <h3 style="font-size:18px; font-weight:600; color:#1a1a2e; margin-bottom:8px;" id="previewName">
                {{ $product->name }}
            </h3>
            <div style="display:flex; justify-content:center; gap:16px; margin-bottom:16px;">
                <span style="font-size:20px; font-weight:700; color:#6f3200;" id="previewPrice">
                    ${{ number_format($product->price, 2) }}
                </span>
                <span style="background:#f1f5f9; padding:4px 12px; border-radius:100px; font-size:13px; color:#64748b;" id="previewStock">
                    <i class="fas fa-box"></i> {{ $product->stock }} in stock
                </span>
            </div>
            <div style="display:flex; gap:8px; justify-content:center;">
                <span style="padding:6px 16px; background:#d1fae5; color:#059669; border-radius:100px; font-size:12px; font-weight:500;">
                    <i class="fas fa-check-circle"></i> Active
                </span>
                @if($product->stock <= 5 && $product->stock > 0)
                    <span style="padding:6px 16px; background:#fef3c7; color:#d97706; border-radius:100px; font-size:12px; font-weight:500;">
                        <i class="fas fa-exclamation-triangle"></i> Low Stock
                    </span>
                @elseif($product->stock == 0)
                    <span style="padding:6px 16px; background:#fee2e2; color:#dc2626; border-radius:100px; font-size:12px; font-weight:500;">
                        <i class="fas fa-times-circle"></i> Out of Stock
                    </span>
                @endif
            </div>
        </div>

        <div style="margin-top:16px; padding:12px 16px; background:#f0fdf4; border-radius:10px; border:1px solid #bbf7d0;">
            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:#166534;">
                <i class="fas fa-lightbulb" style="font-size:16px;"></i>
                <span>Changes will appear here in real-time after saving</span>
            </div>
        </div>
    </div>
</div>

{{-- Real-time preview script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.querySelector('input[name="name"]');
    const priceInput = document.querySelector('input[name="price"]');
    const stockInput = document.querySelector('input[name="stock"]');
    const imageInput = document.querySelector('input[name="image"]');

    const previewName = document.getElementById('previewName');
    const previewPrice = document.getElementById('previewPrice');
    const previewStock = document.getElementById('previewStock');

    // Update preview on input
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || '{{ $product->name }}';
    });

    priceInput.addEventListener('input', function() {
        const val = parseFloat(this.value) || 0;
        previewPrice.textContent = '$' + val.toFixed(2);
    });

    stockInput.addEventListener('input', function() {
        const val = parseInt(this.value) || 0;
        previewStock.innerHTML = '<i class="fas fa-box"></i> ' + val + ' in stock';
    });

    // Image preview
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.querySelector('.preview-image');
                if (previewImage) {
                    previewImage.src = e.target.result;
                }
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>

<style>
    .form-group input:focus {
        border-color: #6f3200;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(111, 50, 0, 0.05);
    }
    .form-group input:hover {
        border-color: #d4a574;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(111, 50, 0, 0.3);
    }
    .btn-outline:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }
    @media (max-width: 768px) {
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        [style*="display:grid; grid-template-columns: 1fr 1fr; gap:16px;"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

@endsection