<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Sales History</h2>
    <a href="<?= base_url('sales/create') ?>" class="btn btn-success">
        <i class="bi bi-cart-plus"></i> Record Sale
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Customer</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sales)): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">No sales recorded yet.</td></tr>
                <?php else: ?>
                <?php foreach ($sales as $s): ?>
                <tr>
                    <td><?= $s['sale_id'] ?></td>
                    <td><?= format_date($s['sale_date']) ?></td>
                    <td><?= e($s['product_name']) ?></td>
                    <td><?= $s['quantity'] ?? $s['quantity_sold'] ?? 0 ?></td>
                    <td><?= format_money($s['unit_price'] ?? $s['selling_price'] ?? 0) ?></td>
                    <td><?= format_money($s['total_amount']) ?></td>
                    <td>
                        <span class="badge bg-<?= $s['payment_type'] === 'credit' ? 'warning text-dark' : 'success' ?>">
                            <?= ucfirst($s['payment_type']) ?>
                        </span>
                    </td>
                    <td><?= e($s['customer_name'] ?? '—') ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
