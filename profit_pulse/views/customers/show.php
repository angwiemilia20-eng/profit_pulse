<div class="mb-4">
    <a href="<?= base_url('customers') ?>" class="text-decoration-none">&larr; Back to Customers</a>
    <h2 class="h4 mt-2"><?= e($customer['customer_name']) ?></h2>
    <p class="text-muted mb-0"><?= e($customer['phone']) ?> · <?= e($customer['address']) ?></p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Debt Records</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Owed</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($debts)): ?>
                <tr><td colspan="5" class="text-muted text-center py-3">No debt records.</td></tr>
                <?php else: ?>
                <?php foreach ($debts as $d): ?>
                <tr>
                    <td><?= format_date($d['date_created']) ?></td>
                    <td><?= format_money($d['amount_owed']) ?></td>
                    <td><?= format_money($d['amount_paid']) ?></td>
                    <td><strong class="<?= $d['balance'] > 0 ? 'text-danger' : 'text-success' ?>"><?= format_money($d['balance']) ?></strong></td>
                    <td><a href="<?= base_url('debts/show?id=' . $d['debt_id']) ?>" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
