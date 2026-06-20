<div class="mb-4">
    <a href="<?= base_url('debts') ?>" class="text-decoration-none">&larr; Back to Debts</a>
    <h2 class="h4 mt-2">Debt #<?= $debt['debt_id'] ?> — <?= e($debt['customer_name']) ?></h2>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Amount Owed</div>
                <div class="fs-4"><?= format_money($debt['amount_owed']) ?></div>
                <hr>
                <div class="text-muted small">Amount Paid</div>
                <div class="fs-4 text-success"><?= format_money($debt['amount_paid']) ?></div>
                <hr>
                <div class="text-muted small">Outstanding Balance</div>
                <div class="fs-3 fw-bold <?= $debt['balance'] > 0 ? 'text-danger' : 'text-success' ?>">
                    <?= format_money($debt['balance']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <?php if ($debt['balance'] > 0): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold">Record Payment</div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('debts/pay') ?>" class="row g-3">
                    <?= csrf_field() ?>
                    <input type="hidden" name="debt_id" value="<?= $debt['debt_id'] ?>">
                    <div class="col-md-4">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" min="0.01" max="<?= $debt['balance'] ?>"
                               name="amount" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" name="payment_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Notes</label>
                        <input type="text" name="notes" class="form-control" placeholder="Optional">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Record Payment</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Payment History</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr><th>Date</th><th>Amount</th><th>Notes</th></tr>
                    </thead>
                    <tbody>
                        <?php if (empty($payments)): ?>
                        <tr><td colspan="3" class="text-muted text-center py-3">No payments yet.</td></tr>
                        <?php else: ?>
                        <?php foreach ($payments as $p): ?>
                        <tr>
                            <td><?= format_date($p['payment_date']) ?></td>
                            <td><?= format_money($p['amount']) ?></td>
                            <td><?= e($p['notes']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
