<?php

declare(strict_types=1);

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
trait Controller
{

    /**
     * Renders a view file and passes data to it.
     *
     * @param string $name The name of the view file (without extension).
     * @param array $data  An optional array of data to pass to the view.
     * @return void
     *
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function view(string $name, array $data = []): void
    {
        if (!empty($data))
            extract($data);

        $viewPath = "../app/views/" . $name . ".view.php";
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            $viewPath = "../app/views/404.view.php";
            require $viewPath;
        }
    }
}