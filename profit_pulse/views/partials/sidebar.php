<div class="sidebar bg-dark text-white" id="sidebar">
    <div class="sidebar-brand p-3 border-bottom border-secondary">
        <a href="<?= base_url('dashboard') ?>" class="text-white text-decoration-none d-flex align-items-center gap-2">
            <i class="bi bi-graph-up-arrow fs-4"></i>
            <span class="fw-semibold"><?= APP_NAME ?></span>
        </a>
    </div>
    <nav class="nav flex-column p-2">
        <a class="nav-link text-white-50 <?= is_active_route('dashboard') ?>" href="<?= base_url('dashboard') ?>">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        <a class="nav-link text-white-50 <?= is_active_route('products') ?>" href="<?= base_url('products') ?>">
            <i class="bi bi-box-seam me-2"></i> Products
        </a>
        <a class="nav-link text-white-50 <?= is_active_route('sales') ?>" href="<?= base_url('sales') ?>">
            <i class="bi bi-cart-check me-2"></i> Sales
        </a>
        <a class="nav-link text-white-50 <?= is_active_route('expenses') ?>" href="<?= base_url('expenses') ?>">
            <i class="bi bi-wallet2 me-2"></i> Expenses
        </a>
        <a class="nav-link text-white-50 <?= is_active_route('customers') ?>" href="<?= base_url('customers') ?>">
            <i class="bi bi-people me-2"></i> Customers
        </a>
        <a class="nav-link text-white-50 <?= is_active_route('debts') ?>" href="<?= base_url('debts') ?>">
            <i class="bi bi-credit-card me-2"></i> Debts
        </a>
        <a class="nav-link text-white-50 <?= is_active_route('products/expiry') ?>" href="<?= base_url('products/expiry') ?>">
            <i class="bi bi-calendar-x me-2"></i> Expiry Alerts
        </a>
        <hr class="border-secondary">
        <span class="nav-link text-white-50 small text-uppercase">Reports</span>
        <a class="nav-link text-white-50 <?= is_active_route('reports/sales') ?>" href="<?= base_url('reports/sales') ?>">
            <i class="bi bi-bar-chart me-2"></i> Sales Report
        </a>
        <a class="nav-link text-white-50 <?= is_active_route('reports/inventory') ?>" href="<?= base_url('reports/inventory') ?>">
            <i class="bi bi-clipboard-data me-2"></i> Inventory Report
        </a>
        <a class="nav-link text-white-50 <?= is_active_route('reports/profit') ?>" href="<?= base_url('reports/profit') ?>">
            <i class="bi bi-currency-dollar me-2"></i> Profit Report
        </a>
    </nav>
</div>
