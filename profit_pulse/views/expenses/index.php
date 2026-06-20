<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">Expenses</h2>
        <p class="text-muted small mb-0">Total: <strong><?= format_money($total) ?></strong></p>
    </div>
    <a href="<?= base_url('expenses/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Expense
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($expenses)): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">No expenses recorded.</td></tr>
                <?php else: ?>
                <?php foreach ($expenses as $e): ?>
                <tr>
                    <td><?= $e['expense_id'] ?></td>
                    <td><?= format_date($e['expense_date']) ?></td>
                    <td><?= e($e['expense_type']) ?></td>
                    <td><?= format_money($e['amount']) ?></td>
                    <td><?= e($e['description']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
