<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h2 class="h5 mb-0">Edit Customer</h2></div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('customers/update') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="customer_id" value="<?= $customer['customer_id'] ?>">
                    <?php require APP_ROOT . '/views/customers/_form.php'; ?>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Customer</button>
                        <a href="<?= base_url('customers') ?>" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
