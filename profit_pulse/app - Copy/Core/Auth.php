<?php

namespace App\Core;

class Auth
{
    public static function login(int $userId, string $username): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['logged_in_at'] = time();
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function username(): ?string
    {
        return $_SESSION['username'] ?? null;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            flash('error', 'Please log in to continue.');
            redirect('login');
        }
    }

    public static function guest(): void
    {
        if (self::check()) {
            redirect('dashboard');
        }
    }
}
