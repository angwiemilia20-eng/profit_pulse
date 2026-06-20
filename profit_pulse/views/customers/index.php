<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Customers</h2>
    <a href="<?= base_url('customers/create') ?>" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> Add Customer
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">No customers registered.</td></tr>
                <?php else: ?>
                <?php foreach ($customers as $c): ?>
                <tr>
                    <td><?= $c['customer_id'] ?></td>
                    <td><?= e($c['customer_name']) ?></td>
                    <td><?= e($c['phone']) ?></td>
                    <td><?= e($c['address']) ?></td>
                    <td>
                        <a href="<?= base_url('customers/show?id=' . $c['customer_id']) ?>" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="<?= base_url('customers/edit?id=' . $c['customer_id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="<?= base_url('customers/delete') ?>" class="d-inline"
                              onsubmit="return confirm('Delete this customer?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="customer_id" value="<?= $c['customer_id'] ?>">
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
