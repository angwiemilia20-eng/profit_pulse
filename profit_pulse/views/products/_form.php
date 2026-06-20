<?php $p = $product ?? []; ?>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Product Name *</label>
        <input type="text" name="product_name" class="form-control" required
               value="<?= e($p['product_name'] ?? old('product_name')) ?>">
    </div>
    <div class="col-md-6">
        <label class="form-label">Category</label>
        <input type="text" name="category" class="form-control"
               value="<?= e($p['category'] ?? old('category', 'General')) ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">Buying Price *</label>
        <input type="number" step="0.01" min="0" name="buying_price" class="form-control" required
               value="<?= e($p['buying_price'] ?? old('buying_price')) ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">Selling Price *</label>
        <input type="number" step="0.01" min="0" name="selling_price" class="form-control" required
               value="<?= e($p['selling_price'] ?? old('selling_price')) ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">Quantity *</label>
        <input type="number" min="0" name="quantity" class="form-control" required
               value="<?= e($p['quantity'] ?? old('quantity', 0)) ?>">
    </div>
    <div class="col-md-6">
        <label class="form-label">Low Stock Threshold</label>
        <input type="number" min="0" name="low_stock_threshold" class="form-control"
               value="<?= e($p['low_stock_threshold'] ?? old('low_stock_threshold', LOW_STOCK_THRESHOLD)) ?>">
    </div>
    <div class="col-md-6">
        <label class="form-label">Expiry Date</label>
        <input type="date" name="expiry_date" class="form-control"
               value="<?= e($p['expiry_date'] ?? old('expiry_date')) ?>">
    </div>
</div>
<div class="mb-3"></div>
