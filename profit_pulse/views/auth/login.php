<form method="POST" action="<?= base_url('login') ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username"
               value="<?= e(old('username')) ?>" required autofocus>
    </div>

    <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Sign In</button>

    <p class="text-muted small text-center mt-3 mb-0">
        Default: <code>admin</code> / <code>admin123</code>
    </p>
</form>
