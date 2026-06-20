<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">Record Sale</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('sales/store') ?>" id="saleForm">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Product *</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">Select product...</option>
                            <?php foreach ($products as $p): ?>
                            <option value="<?= $p['product_id'] ?>"
                                    data-price="<?= $p['selling_price'] ?>"
                                    data-stock="<?= $p['quantity'] ?>">
                                <?= e($p['product_name']) ?> (Stock: <?= $p['quantity'] ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Quantity *</label>
                            <input type="number" min="1" name="quantity" id="quantity" class="form-control" required value="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Unit Price</label>
                            <input type="text" id="unit_price" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Total</label>
                            <input type="text" id="total_amount" class="form-control fw-bold" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Payment Type *</label>
                        <select name="payment_type" id="payment_type" class="form-select" required>
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>

                    <div class="mb-3" id="customerField" style="display:none;">
                        <label class="form-label">Customer *</label>
                        <select name="customer_id" class="form-select">
                            <option value="">Select customer...</option>
                            <?php foreach ($customers as $c): ?>
                            <option value="<?= $c['customer_id'] ?>"><?= e($c['customer_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">
                            No customer? <a href="<?= base_url('customers/create') ?>">Add one first</a>.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sale Date *</label>
                        <input type="date" name="sale_date" class="form-control" required value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Record Sale</button>
                        <a href="<?= base_url('sales') ?>" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const productSelect = document.getElementById('product_id');
    const qtyInput = document.getElementById('quantity');
    const unitPrice = document.getElementById('unit_price');
    const totalAmount = document.getElementById('total_amount');
    const paymentType = document.getElementById('payment_type');
    const customerField = document.getElementById('customerField');

    function updateTotals() {
        const opt = productSelect.selectedOptions[0];
        const price = parseFloat(opt?.dataset.price || 0);
        const qty = parseInt(qtyInput.value || 0, 10);
        unitPrice.value = price.toFixed(2);
        totalAmount.value = (price * qty).toFixed(2);
    }

    productSelect.addEventListener('change', updateTotals);
    qtyInput.addEventListener('input', updateTotals);

    paymentType.addEventListener('change', function () {
        customerField.style.display = this.value === 'credit' ? 'block' : 'none';
    });
});
</script>
