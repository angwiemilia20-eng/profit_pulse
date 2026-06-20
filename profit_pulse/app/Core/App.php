<?php

namespace App\Core;

class App
{
    public static function run(): void
    {
        self::registerAutoloader();

        require APP_ROOT . '/config/config.php';
        require APP_ROOT . '/app/Helpers/functions.php';

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $router = require APP_ROOT . '/routes/web.php';

        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $router->dispatch($uri, $method);
    }

    private static function registerAutoloader(): void
    {
        spl_autoload_register(function (string $class) {

            $prefix = 'App\\';

            if (!str_starts_with($class, $prefix)) {
                return;
            }

            $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
            $file = APP_ROOT . '/app/' . $relative . '.php';

            if (file_exists($file)) {
                require $file;
            }
        });
    }
}