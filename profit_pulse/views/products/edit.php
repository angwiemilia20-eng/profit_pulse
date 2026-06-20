<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">Edit Product</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('products/update') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                    <?php require APP_ROOT . '/views/products/_form.php'; ?>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="<?= base_url('products') ?>" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
