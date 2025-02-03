<?php

defined('ROOT_PATH') or exit('Access Denied!');

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class App
{
    private string $controller = 'Home';
    private string $method = 'index';

    private function splitURL()
    {
        $url = $_GET['url'] ?? 'home';
        return explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));
    }

    public function loadController()
    {
        $URL = $this->splitURL();

        $controllerName = ucfirst($URL[0]);
        $controllerFile = "../app/controllers/{$controllerName}.php";
        if (file_exists($controllerFile)) {
            require $controllerFile;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            $controllerFile = "../app/controllers/_404.php";
            require $controllerFile;
            $this->controller = "_404";
        }

        $controller = new ('\Controller\\' . $this->controller);

        if (!empty($URL[1]) && method_exists($controller, $URL[1])) {
            $this->method = $URL[1];
            unset($URL[1]);
        }

        call_user_func_array([$controller, $this->method], $URL);
    }
}


