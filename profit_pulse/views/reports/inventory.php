<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Available Stock</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr><th>Product</th><th>Category</th><th>Qty</th><th>Value (Sell)</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td><?= e($p['product_name']) ?></td>
                            <td><?= e($p['category']) ?></td>
                            <td><?= $p['quantity'] ?></td>
                            <td><?= format_money($p['quantity'] * $p['selling_price']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning fw-semibold">Low Stock Items</div>
            <ul class="list-group list-group-flush">
                <?php if (empty($lowStock)): ?>
                <li class="list-group-item text-muted">All items sufficiently stocked.</li>
                <?php else: ?>
                <?php foreach ($lowStock as $p): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <?= e($p['product_name']) ?>
                    <span class="badge bg-warning text-dark"><?= $p['quantity'] ?></span>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
