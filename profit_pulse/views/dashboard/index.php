<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Today's Sales</div>
                <div class="fs-4 fw-bold text-primary"><?= format_money($todaySales) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Total Sales</div>
                <div class="fs-4 fw-bold"><?= format_money($totalSales) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Gross Profit</div>
                <div class="fs-4 fw-bold text-success"><?= format_money($grossProfit) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Net Profit</div>
                <div class="fs-4 fw-bold <?= $netProfit >= 0 ? 'text-success' : 'text-danger' ?>">
                    <?= format_money($netProfit) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">Quick Stats</div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span>Products</span><strong><?= $productCount ?></strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span>Total Expenses</span><strong><?= format_money($totalExpenses) ?></strong>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span>Outstanding Debt</span><strong class="text-danger"><?= format_money($totalDebt) ?></strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold text-warning">
                <i class="bi bi-exclamation-triangle me-1"></i> Low Stock (<?= count($lowStock) ?>)
            </div>
            <div class="card-body p-0">
                <?php if (empty($lowStock)): ?>
                    <p class="text-muted p-3 mb-0">All products are sufficiently stocked.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach (array_slice($lowStock, 0, 5) as $item): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <?= e($item['product_name']) ?>
                            <span class="badge bg-warning text-dark"><?= $item['quantity'] ?> left</span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold text-danger">
                <i class="bi bi-calendar-x me-1"></i> Expiry Alerts
            </div>
            <div class="card-body p-0">
                <?php if (empty($expiringSoon) && empty($expired)): ?>
                    <p class="text-muted p-3 mb-0">No expiry issues detected.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach (array_slice($expired, 0, 3) as $item): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <?= e($item['product_name']) ?>
                            <span class="badge bg-danger">Expired</span>
                        </li>
                        <?php endforeach; ?>
                        <?php foreach (array_slice($expiringSoon, 0, 3) as $item): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <?= e($item['product_name']) ?>
                            <span class="badge bg-warning text-dark"><?= format_date($item['expiry_date']) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-wrap gap-2">
    <a href="<?= base_url('products/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Product</a>
    <a href="<?= base_url('sales/create') ?>" class="btn btn-success"><i class="bi bi-cart-plus"></i> Record Sale</a>
    <a href="<?= base_url('expenses/create') ?>" class="btn btn-secondary"><i class="bi bi-wallet2"></i> Add Expense</a>
    <a href="<?= base_url('reports/profit') ?>" class="btn btn-outline-primary"><i class="bi bi-graph-up"></i> Profit Report</a>
</div>
