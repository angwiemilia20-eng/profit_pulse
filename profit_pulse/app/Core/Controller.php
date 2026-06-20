<?php

namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        View::render($view, $data, $layout);
    }

    protected function redirect(string $path): void
    {
        redirect($path);
    }

    protected function requireAuth(): void
    {
        Auth::requireLogin();
    }

    protected function validateCsrf(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !verify_csrf()) {
            http_response_code(403);
            die('Invalid security token. Please go back and try again.');
        }
    }

    protected function storeOld(array $input): void
    {
        $_SESSION['_old'] = $input;
    }

    protected function clearOld(): void
    {
        unset($_SESSION['_old']);
    }
}
