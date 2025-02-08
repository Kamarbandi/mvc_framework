<?php

namespace Core;

defined('ROOT_PATH') or exit('Access Denied!');

class Session
{
    public $mainkey = 'APP';
    public $userkey = 'USER';

    /**
     * @return int
     */
    private function start_session(): int
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return 1;
    }

    /**
     * @param mixed $keyOrArray
     * @param mixed $value
     * @return int
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function set(mixed $keyOrArray, mixed $value = ''): int
    {
        $this->start_session();

        if (is_array($keyOrArray)) {
            foreach ($keyOrArray as $key => $value) {

                $_SESSION[$this->mainkey][$key] = $value;
            }

            return 1;
        }

        $_SESSION[$this->mainkey][$keyOrArray] = $value;

        return 1;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function get(string $key, mixed $default = ''): mixed
    {
        $this->start_session();

        if (isset($_SESSION[$this->mainkey][$key])) {
            return $_SESSION[$this->mainkey][$key];
        }

        return $default;
    }

    /**
     * @param mixed $user_row
     * @return int
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function auth(mixed $user_row): int
    {
        $this->start_session();

        $_SESSION[$this->userkey] = $user_row;

        return 0;
    }

    /**
     * @return int
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function logout(): int
    {
        $this->start_session();

        if (!empty($_SESSION[$this->userkey])) {

            unset($_SESSION[$this->userkey]);
        }

        return 0;
    }

    /**
     * @return bool
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function is_logged_in(): bool
    {
        $this->start_session();

        if (!empty($_SESSION[$this->userkey])) {

            return true;
        }

        return false;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function user(string $key = '', mixed $default = ''): mixed
    {
        $this->start_session();

        if (empty($key) && !empty($_SESSION[$this->userkey])) {

            return $_SESSION[$this->userkey];
        } else if (!empty($_SESSION[$this->userkey]->$key)) {
            return $_SESSION[$this->userkey]->$key;
        }

        return $default;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function pop(string $key, mixed $default = ''): mixed
    {
        $this->start_session();

        if (!empty($_SESSION[$this->mainkey][$key])) {

            $value = $_SESSION[$this->mainkey][$key];
            unset($_SESSION[$this->mainkey][$key]);
            return $value;
        }

        return $default;
    }

    /**
     * @return mixed
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function all(): mixed
    {
        $this->start_session();

        if (isset($_SESSION[$this->mainkey])) {
            return $_SESSION[$this->mainkey];
        }

        return [];
    }
}

