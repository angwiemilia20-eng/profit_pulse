<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Products</h2>
    <a href="<?= base_url('products/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Product
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Buy Price</th>
                    <th>Sell Price</th>
                    <th>Qty</th>
                    <th>Expiry</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">No products yet.</td></tr>
                <?php else: ?>
                <?php foreach ($products as $p): ?>
                <tr class="<?= $p['quantity'] <= $p['low_stock_threshold'] ? 'table-warning' : '' ?>">
                    <td><?= $p['product_id'] ?></td>
                    <td><?= e($p['product_name']) ?></td>
                    <td><?= e($p['category']) ?></td>
                    <td><?= format_money($p['buying_price']) ?></td>
                    <td><?= format_money($p['selling_price']) ?></td>
                    <td>
                        <?= $p['quantity'] ?>
                        <?php if ($p['quantity'] <= $p['low_stock_threshold']): ?>
                            <span class="badge bg-warning text-dark">Low</span>
                        <?php endif; ?>
                    </td>
                    <td><?= format_date($p['expiry_date']) ?></td>
                    <td>
                        <a href="<?= base_url('products/edit?id=' . $p['product_id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="<?= base_url('products/delete') ?>" class="d-inline"
                              onsubmit="return confirm('Delete this product?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
