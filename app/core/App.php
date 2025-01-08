<?php

declare(strict_types=1);

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class App
{
    private string $controller = 'Home';
    private string $method = 'index';

    /**
     * @return string[]
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    private function splitURL(): array
    {
        $url = $_GET['url'] ?? 'home';
        return explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));
    }

    /**
     * Loads the controller and calls the appropriate method.
     *
     * @return void
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function loadController(): void
    {
        $urlParts = $this->splitURL();
        $controllerName = ucfirst($urlParts[0]);

        $filename = "../app/controllers/{$controllerName}.php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = $controllerName;
            unset($urlParts[0]);
        } else {

            $filename = "../app/controllers/NotFound.php";
            require $filename;
            $this->controller = "NotFound";
        }

        $controllerInstance  = new $this->controller;

        if (!empty($urlParts[1])) {
            if (method_exists($controllerInstance , $urlParts[1])) {
                $this->method = $urlParts[1];
                unset($urlParts[1]);
            }
        }

        call_user_func_array([$controllerInstance, $this->method], $urlParts);
    }
}


