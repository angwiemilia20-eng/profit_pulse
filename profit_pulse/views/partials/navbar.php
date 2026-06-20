<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4">
    <button class="btn btn-outline-secondary btn-sm d-lg-none" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
    <span class="navbar-brand mb-0 h6 ms-2"><?= e($pageTitle ?? '') ?></span>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="text-muted small">
            <i class="bi bi-person-circle me-1"></i><?= e(\App\Core\Auth::username()) ?>
        </span>
        <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</nav>
