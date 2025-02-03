<?php

namespace Controller;

defined('ROOT_PATH') or exit('Access Denied!');

/**
 * Trait MainController
 * Provides functionality to render views.
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
trait MainController
{
    /**
     * Renders a view with optional data.
     *
     * @param string $viewName Name of the view file (without extension).
     * @param array $data Data to be extracted for use within the view.
     * @return void
     */
    public function view(string $viewName, array $data = []): void
    {
        // Safely extract data for use in view, if provided
        if (!empty($data)) {
            extract($data, EXTR_SKIP); // EXTR_SKIP ensures no overwriting of existing variables
        }

        $viewFile = "../app/views/{$viewName}.view.php";

        if (is_readable($viewFile)) {
            require $viewFile;
        } else {
            $this->render404();
        }
    }

    /**
     * Renders the 404 error page.
     *
     * @return void
     */
    private function render404(): void
    {
        $errorViewFile = "../app/views/404.view.php";

        // Ensure 404 view exists, otherwise exit with error message
        if (is_readable($errorViewFile)) {
            require $errorViewFile;
        } else {
            exit('Error: 404 view not found.');
        }
    }
}
