<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Customer Debts</h2>
        <p class="text-muted small mb-0">Total Outstanding: <strong class="text-danger"><?= format_money($totalOutstanding) ?></strong></p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Owed</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($debts)): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">No outstanding debts.</td></tr>
                <?php else: ?>
                <?php foreach ($debts as $d): ?>
                <tr>
                    <td><?= $d['debt_id'] ?></td>
                    <td><?= e($d['customer_name']) ?></td>
                    <td><?= e($d['phone']) ?></td>
                    <td><?= format_money($d['amount_owed']) ?></td>
                    <td><?= format_money($d['amount_paid']) ?></td>
                    <td><strong class="<?= $d['balance'] > 0 ? 'text-danger' : 'text-success' ?>"><?= format_money($d['balance']) ?></strong></td>
                    <td><?= format_date($d['date_created']) ?></td>
                    <td><a href="<?= base_url('debts/show?id=' . $d['debt_id']) ?>" class="btn btn-sm btn-outline-primary">Details</a></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
