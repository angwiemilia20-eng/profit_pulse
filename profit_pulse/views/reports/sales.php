<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Daily Sales</span>
                <form method="GET" class="d-flex gap-2">
                    <input type="date" name="date" class="form-control form-control-sm" value="<?= e($date) ?>">
                    <input type="hidden" name="year" value="<?= $year ?>">
                    <input type="hidden" name="month" value="<?= $month ?>">
                    <button class="btn btn-sm btn-primary">Go</button>
                </form>
            </div>
            <div class="card-body">
                <p class="mb-3">Total for <?= format_date($date) ?>: <strong><?= format_money($dailyTotal) ?></strong></p>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>Product</th><th>Qty</th><th>Total</th></tr></thead>
                        <tbody>
                            <?php if (empty($dailySales)): ?>
                            <tr><td colspan="3" class="text-muted">No sales on this date.</td></tr>
                            <?php else: ?>
                            <?php foreach ($dailySales as $s): ?>
                            <tr>
                                <td><?= e($s['product_name']) ?></td>
                                <td><?= $s['quantity'] ?></td>
                                <td><?= format_money($s['total_amount']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Monthly Sales</span>
                <form method="GET" class="d-flex gap-2">
                    <input type="hidden" name="date" value="<?= e($date) ?>">
                    <select name="month" class="form-select form-select-sm">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= $m === $month ? 'selected' : '' ?>><?= date('F', mktime(0,0,0,$m,1)) ?></option>
                        <?php endfor; ?>
                    </select>
                    <input type="number" name="year" class="form-control form-control-sm" value="<?= $year ?>" min="2020" max="2099">
                    <button class="btn btn-sm btn-primary">Go</button>
                </form>
            </div>
            <div class="card-body">
                <p class="mb-3">Total for <?= date('F Y', mktime(0,0,0,$month,1,$year)) ?>: <strong><?= format_money($monthlyTotal) ?></strong></p>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>Date</th><th>Product</th><th>Total</th></tr></thead>
                        <tbody>
                            <?php if (empty($monthlySales)): ?>
                            <tr><td colspan="3" class="text-muted">No sales this month.</td></tr>
                            <?php else: ?>
                            <?php foreach ($monthlySales as $s): ?>
                            <tr>
                                <td><?= format_date($s['sale_date']) ?></td>
                                <td><?= e($s['product_name']) ?></td>
                                <td><?= format_money($s['total_amount']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
