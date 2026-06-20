<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">Add Expense</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('expenses/store') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Expense Type *</label>
                        <input type="text" name="expense_type" class="form-control" required
                               placeholder="e.g. Rent, Utilities, Transport"
                               value="<?= e(old('expense_type')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount *</label>
                        <input type="number" step="0.01" min="0.01" name="amount" class="form-control" required
                               value="<?= e(old('amount')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date *</label>
                        <input type="date" name="expense_date" class="form-control" required
                               value="<?= e(old('expense_date', date('Y-m-d'))) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= e(old('description')) ?></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Expense</button>
                        <a href="<?= base_url('expenses') ?>" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
