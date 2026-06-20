<?php $c = $customer ?? []; ?>
<div class="mb-3">
    <label class="form-label">Customer Name *</label>
    <input type="text" name="customer_name" class="form-control" required
           value="<?= e($c['customer_name'] ?? old('customer_name')) ?>">
</div>
<div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control"
           value="<?= e($c['phone'] ?? old('phone')) ?>">
</div>
<div class="mb-3">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control" rows="2"><?= e($c['address'] ?? old('address')) ?></textarea>
</div>
