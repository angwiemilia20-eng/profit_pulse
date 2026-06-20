<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Login') ?> — <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= asset('css/app.css') ?>" rel="stylesheet">
</head>
<body class="auth-body">
<div class="auth-wrapper d-flex align-items-center justify-content-center min-vh-100">
    <div class="auth-card card shadow-lg border-0">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <i class="bi bi-graph-up-arrow text-primary fs-1"></i>
                <h1 class="h3 mt-2"><?= APP_NAME ?></h1>
                <p class="text-muted small">Inventory, Sales & Profit Management</p>
            </div>
            <?php require APP_ROOT . '/views/partials/alerts.php'; ?>
            <?= $content ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
