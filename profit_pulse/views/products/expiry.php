<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-danger text-white fw-semibold">
                Expired Products (<?= count($expired) ?>)
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Product</th><th>Qty</th><th>Expired On</th></tr></thead>
                    <tbody>
                        <?php if (empty($expired)): ?>
                        <tr><td colspan="3" class="text-muted text-center py-3">None</td></tr>
                        <?php else: ?>
                        <?php foreach ($expired as $p): ?>
                        <tr>
                            <td><?= e($p['product_name']) ?></td>
                            <td><?= $p['quantity'] ?></td>
                            <td><?= format_date($p['expiry_date']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning fw-semibold">
                Expiring Within <?= EXPIRY_ALERT_DAYS ?> Days (<?= count($expiringSoon) ?>)
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Product</th><th>Qty</th><th>Expires</th></tr></thead>
                    <tbody>
                        <?php if (empty($expiringSoon)): ?>
                        <tr><td colspan="3" class="text-muted text-center py-3">None</td></tr>
                        <?php else: ?>
                        <?php foreach ($expiringSoon as $p): ?>
                        <tr>
                            <td><?= e($p['product_name']) ?></td>
                            <td><?= $p['quantity'] ?></td>
                            <td><?= format_date($p['expiry_date']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
