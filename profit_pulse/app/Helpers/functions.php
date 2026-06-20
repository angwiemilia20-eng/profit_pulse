<?php

function base_url(string $path = ''): string
{
    $path = ltrim($path, '/');
    return rtrim(APP_URL, '/') . ($path ? '/' . $path : '');
}

function asset(string $path): string
{
    return base_url('public/' . ltrim($path, '/'));
}

function redirect(string $path): void
{
    header('Location: ' . base_url($path));
    exit;
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['_old'][$key] ?? $default;
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $value;
}

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . csrf_token() . '">';
}

function verify_csrf(): bool
{
    $token = $_POST['_csrf'] ?? '';
    return hash_equals($_SESSION['_csrf'] ?? '', $token);
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function format_money(float|int|string $amount): string
{
    return number_format((float) $amount, 2);
}

function format_date(?string $date): string
{
    if (!$date) {
        return '—';
    }
    return date('M d, Y', strtotime($date));
}

function is_active_route(string $route): string
{
    $current = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    $base = trim(parse_url(APP_URL, PHP_URL_PATH), '/');
    if ($base && str_starts_with($current, $base)) {
        $current = trim(substr($current, strlen($base)), '/');
    }
    return str_starts_with($current, trim($route, '/')) ? 'active' : '';
}
