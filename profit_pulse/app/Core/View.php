<?php

namespace App\Core;

class View
{
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        extract($data);

        $viewFile = APP_ROOT . '/views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die("View not found: {$view}");
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        $layoutFile = APP_ROOT . '/views/layouts/' . $layout . '.php';
        if (!file_exists($layoutFile)) {
            echo $content;
            return;
        }

        require $layoutFile;
    }
}
