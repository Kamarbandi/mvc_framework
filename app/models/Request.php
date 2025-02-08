<?php

/**
 * Request class
 * Gets and sets data in the POST and GET global variables
 */

namespace Core;

defined('ROOT_PATH') or exit('Access Denied!');

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class Request
{
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
        if ($_SERVER['REQUEST_METHOD'] == "POST" && count($_POST) > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function post(string $key = '', mixed $default = ''): mixed
    {
        if (empty($key)) {
            return $_POST;
        } else if (isset($_POST[$key])) {
            return $_POST[$key];
        }

        return $default;
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
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }

        return $default;
    }

    /**
     * @return mixed
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function all(): mixed
    {
        return $_REQUEST;
    }
}