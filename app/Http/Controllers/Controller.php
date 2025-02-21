<?php

namespace App\Http\Controllers;

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class Controller
{
    public function response() {
        return new class {
            public function json($data, $statusCode = 200) {
                http_response_code($statusCode);
                header('Content-Type: application/json');
                echo json_encode($data);
            }
        };
    }

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
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    private function render404(): void
    {
        $errorViewFile = "../../app/views/404.view.php";

        // Ensure 404 view exists, otherwise exit with error message
        if (is_readable($errorViewFile)) {
            /** @phpstan-ignore-next-line  */
            require $errorViewFile;
        } else {
            exit('Error: 404 view not found.');
        }
    }

    /**
     * Sends a JSON error response with a specific message and status code.
     *
     * @param string $message The error message to be returned.
     * @param int $statusCode HTTP status code (default is 400).
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function jsonError(string $message, int $statusCode = 400)
    {
        $this->response()->json(['error' => $message], $statusCode);
    }

    /**
     * @return array|null
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function getJsonRequestBody(): ?array
    {
        // We get "raw" data from the request body
        $rawInput = file_get_contents('php://input');

        // Trying to decode JSON
        $jsonData = json_decode($rawInput, true);

        // Checking for successful decoding
        if (json_last_error() === JSON_ERROR_NONE) {
            return $jsonData;
        }

        // If the JSON is invalid, return null
        return null;
    }
}