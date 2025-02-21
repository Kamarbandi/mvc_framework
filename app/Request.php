<?php

namespace App;

class Request
{
    protected array $jsonData = [];

    public function __construct()
    {
        // If the request Content-Type is JSON, we try to decode the request body
        if ($this->isJson()) {
            $this->jsonData = json_decode(file_get_contents('php://input'), true) ?? [];
        }
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return bool
     */
    public function posted(): bool
    {
        return $this->method() === "POST" && (count($_POST) > 0 || !empty($this->jsonData));
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function post(string $key = '', mixed $default = ''): mixed
    {
        // First, we look for data in a regular POST
        if (empty($key)) {
            return $_POST ?: $this->jsonData;
        } else if (isset($_POST[$key])) {
            return $_POST[$key];
        }

        // If you didn't find it in POST, look in JSON
        return $this->jsonData[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function files(string $key = '', mixed $default = ''): mixed
    {
        if (empty($key)) {
            return $_FILES;
        } else if (isset($_FILES[$key])) {
            return $_FILES[$key];
        }

        return $default;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key = '', mixed $default = ''): mixed
    {
        if (empty($key)) {
            return $_GET;
        } else if (isset($_GET[$key])) {
            return $_GET[$key];
        }

        return $default;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function input(string $key, mixed $default = ''): mixed
    {
        return $_REQUEST[$key] ?? $this->jsonData[$key] ?? $default;
    }

    /**
     * @return mixed
     */
    public function all(): mixed
    {
        return array_merge($_REQUEST, $this->jsonData);
    }

    /**
     * @return bool
     */
    protected function isJson(): bool
    {
        return isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
    }
}
