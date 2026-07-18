@extends('dashboard')

@section('content')

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <div>
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:4px;">
            <i class="fas fa-plus-circle" style="font-size:28px; color:#6f3200;"></i>
            <h1 style="font-size:28px; font-weight:700; color:#1a1a2e; margin:0;">Add New Coffee</h1>
            <span style="background:#d1fae5; padding:2px 12px; border-radius:100px; font-size:13px; color:#059669;">
                <i class="fas fa-sparkles"></i> New
            </span>
        </div>
        <p style="color:#64748b; font-size:14px; margin:0;">Add a new coffee to your menu</p>
    </div>
    <a href="/products" class="btn btn-outline" style="padding:10px 20px; border-radius:12px; background:transparent; color:#64748b; border:1px solid #e2e8f0; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-weight:500; transition:all 0.2s;">
        <i class="fas fa-arrow-left"></i> Back to Menu
    </a>
</div>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; max-width:1000px;">
    
    {{-- Create Form --}}
    <div style="background:white; border-radius:16px; padding:32px; border:1px solid #eef2f6;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
            <div style="background:#d1fae5; width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#059669;">
                <i class="fas fa-coffee"></i>
            </div>
            <div>
                <h3 style="font-size:16px; font-weight:600; color:#1a1a2e; margin:0;">New Coffee Details</h3>
                <p style="font-size:13px; color:#64748b; margin:0;">Fill in the information below</p>
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

        <form action="/products" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group" style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#1a1a2e; margin-bottom:6px;">
                    <i class="fas fa-coffee" style="color:#6f3200; margin-right:6px;"></i> Coffee Name <span style="color:#dc2626;">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       style="width:100%; padding:12px 16px; border:2px solid #eef2f6; border-radius:10px; font-size:14px; outline:none; transition:border-color 0.2s; background:#fafafa;"
                       placeholder="e.g. Caramel Latte" required>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:20px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#1a1a2e; margin-bottom:6px;">
                        <i class="fas fa-dollar-sign" style="color:#6f3200; margin-right:6px;"></i> Price ($) <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                           style="width:100%; padding:12px 16px; border:2px solid #eef2f6; border-radius:10px; font-size:14px; outline:none; transition:border-color 0.2s; background:#fafafa;"
                           placeholder="0.00" required min="0">
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#1a1a2e; margin-bottom:6px;">
                        <i class="fas fa-box" style="color:#6f3200; margin-right:6px;"></i> Stock <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="number" name="stock" value="{{ old('stock') }}"
                           style="width:100%; padding:12px 16px; border:2px solid #eef2f6; border-radius:10px; font-size:14px; outline:none; transition:border-color 0.2s; background:#fafafa;"
                           placeholder="0" required min="0">
                </div>
            </div>

            <div class="form-group" style="margin-bottom:24px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#1a1a2e; margin-bottom:6px;">
                    <i class="fas fa-image" style="color:#6f3200; margin-right:6px;"></i> Product Image
                </label>
                <div style="border:2px dashed #eef2f6; border-radius:10px; padding:20px; text-align:center; background:#fafafa; transition:all 0.3s; cursor:pointer;" id="dropZone">
                    <input type="file" name="image" accept="image/*" 
                           style="display:none;" id="imageInput">
                    <div id="uploadPlaceholder">
                        <i class="fas fa-cloud-upload-alt" style="font-size:32px; color:#94a3b8; margin-bottom:8px; display:block;"></i>
                        <p style="font-size:14px; color:#64748b; margin:0;">
                            <strong style="color:#6f3200;">Click to upload</strong> or drag and drop
                        </p>
                        <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">
                            PNG, JPG, JPEG (Max 2MB)
                        </p>
                    </div>
                    <div id="imagePreview" style="display:none;">
                        <img id="previewImg" src="#" alt="Preview" style="max-width:150px; max-height:150px; border-radius:8px; margin-bottom:8px;">
                        <p style="font-size:13px; color:#059669; font-weight:500;">
                            <i class="fas fa-check-circle"></i> Image selected
                        </p>
                        <button type="button" onclick="removeImage()" style="background:#fee2e2; color:#dc2626; border:none; padding:4px 12px; border-radius:6px; font-size:12px; cursor:pointer;">
                            Remove
                        </button>
                    </div>
                </div>
                <small style="color:#94a3b8; font-size:12px; display:block; margin-top:6px;">
                    <i class="fas fa-info-circle"></i> Optional. Upload a product image
                </small>
            </div>

            <div style="display:flex; gap:12px; border-top:1px solid #eef2f6; padding-top:20px;">
                <button type="submit" class="btn btn-primary" 
                        style="flex:1; padding:12px 24px; border-radius:12px; background:#6f3200; color:white; border:none; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                    <i class="fas fa-save"></i> Save Coffee
                </button>
                <a href="/products" class="btn btn-outline" 
                   style="flex:1; padding:12px 24px; border-radius:12px; background:transparent; color:#64748b; border:1px solid #e2e8f0; text-decoration:none; text-align:center; font-size:14px; font-weight:500; transition:all 0.2s; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    {{-- Preview Card --}}
    <div style="background:white; border-radius:16px; padding:32px; border:1px solid #eef2f6; height:fit-content; position:sticky; top:100px;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
            <div style="background:#e0f2fe; width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#0284c7;">
                <i class="fas fa-eye"></i>
            </div>
            <div>
                <h3 style="font-size:16px; font-weight:600; color:#1a1a2e; margin:0;">Live Preview</h3>
                <p style="font-size:13px; color:#64748b; margin:0;">See your coffee as you type</p>
            </div>
        </div>

        <div style="background:#f8f9fc; border-radius:12px; padding:24px; text-align:center;">
            <div style="font-size:72px; margin-bottom:16px;" id="previewEmoji">
                ☕
            </div>
            <div id="previewImageContainer" style="display:none;">
                <img id="livePreviewImg" src="#" alt="Preview" style="width:120px; height:120px; border-radius:12px; object-fit:cover; margin:0 auto 16px; display:block;">
            </div>
            <h3 style="font-size:18px; font-weight:600; color:#1a1a2e; margin-bottom:8px;" id="previewName">
                Coffee Name
            </h3>
            <div style="display:flex; justify-content:center; gap:16px; margin-bottom:16px;">
                <span style="font-size:20px; font-weight:700; color:#6f3200;" id="previewPrice">
                    $0.00
                </span>
                <span style="background:#f1f5f9; padding:4px 12px; border-radius:100px; font-size:13px; color:#64748b;" id="previewStock">
                    <i class="fas fa-box"></i> 0 in stock
                </span>
            </div>
            <div style="display:flex; gap:8px; justify-content:center;">
                <span style="padding:6px 16px; background:#d1fae5; color:#059669; border-radius:100px; font-size:12px; font-weight:500;">
                    <i class="fas fa-check-circle"></i> Active
                </span>
                <span style="padding:6px 16px; background:#f1f5f9; color:#64748b; border-radius:100px; font-size:12px; font-weight:500;" id="statusBadge">
                    <i class="fas fa-spinner"></i> New
                </span>
            </div>
        </div>

        <div style="margin-top:16px; padding:12px 16px; background:#f0fdf4; border-radius:10px; border:1px solid #bbf7d0;">
            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:#166534;">
                <i class="fas fa-lightbulb" style="font-size:16px;"></i>
                <span>Preview updates in real-time as you fill in the form</span>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for live preview and image upload --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.querySelector('input[name="name"]');
    const priceInput = document.querySelector('input[name="price"]');
    const stockInput = document.querySelector('input[name="stock"]');
    const imageInput = document.getElementById('imageInput');
    const dropZone = document.getElementById('dropZone');

    const previewName = document.getElementById('previewName');
    const previewPrice = document.getElementById('previewPrice');
    const previewStock = document.getElementById('previewStock');
    const previewEmoji = document.getElementById('previewEmoji');
    const previewImageContainer = document.getElementById('previewImageContainer');
    const livePreviewImg = document.getElementById('livePreviewImg');
    const statusBadge = document.getElementById('statusBadge');

    // Update name preview
    nameInput.addEventListener('input', function() {
        const val = this.value || 'Coffee Name';
        previewName.textContent = val;
        if (val && val !== 'Coffee Name') {
            statusBadge.innerHTML = '<i class="fas fa-check-circle"></i> Ready';
            statusBadge.style.background = '#d1fae5';
            statusBadge.style.color = '#059669';
        }
    });

    // Update price preview
    priceInput.addEventListener('input', function() {
        const val = parseFloat(this.value) || 0;
        previewPrice.textContent = '$' + val.toFixed(2);
    });

    // Update stock preview
    stockInput.addEventListener('input', function() {
        const val = parseInt(this.value) || 0;
        previewStock.innerHTML = '<i class="fas fa-box"></i> ' + val + ' in stock';
        
        // Update status badge based on stock
        if (val <= 0) {
            statusBadge.innerHTML = '<i class="fas fa-times-circle"></i> Out of Stock';
            statusBadge.style.background = '#fee2e2';
            statusBadge.style.color = '#dc2626';
        } else if (val <= 5) {
            statusBadge.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Low Stock';
            statusBadge.style.background = '#fef3c7';
            statusBadge.style.color = '#d97706';
        } else {
            statusBadge.innerHTML = '<i class="fas fa-check-circle"></i> In Stock';
            statusBadge.style.background = '#d1fae5';
            statusBadge.style.color = '#059669';
        }
    });

    // Image upload preview
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Hide emoji, show image
                previewEmoji.style.display = 'none';
                previewImageContainer.style.display = 'block';
                livePreviewImg.src = e.target.result;
                
                // Update upload placeholder
                document.getElementById('uploadPlaceholder').style.display = 'none';
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('previewImg').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Click on drop zone to trigger file input
    dropZone.addEventListener('click', function() {
        imageInput.click();
    });

    // Drag and drop support
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#6f3200';
        this.style.background = '#fef3c7';
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = '#eef2f6';
        this.style.background = '#fafafa';
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#eef2f6';
        this.style.background = '#fafafa';
        
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            imageInput.files = e.dataTransfer.files;
            imageInput.dispatchEvent(new Event('change'));
        }
    });
});

// Remove image function
function removeImage() {
    const imageInput = document.getElementById('imageInput');
    const previewImg = document.getElementById('previewImg');
    const livePreviewImg = document.getElementById('livePreviewImg');
    const previewEmoji = document.getElementById('previewEmoji');
    const previewImageContainer = document.getElementById('previewImageContainer');
    
    imageInput.value = '';
    previewImg.src = '#';
    livePreviewImg.src = '#';
    previewEmoji.style.display = 'block';
    previewImageContainer.style.display = 'none';
    document.getElementById('uploadPlaceholder').style.display = 'block';
    document.getElementById('imagePreview').style.display = 'none';
}
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
    #dropZone {
        transition: all 0.3s ease;
    }
    #dropZone:hover {
        border-color: #6f3200;
        background: #fef3c7;
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