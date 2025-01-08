<?php

declare(strict_types=1);

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class User
{
    use Model;

    protected string $table = 'users';

    protected array $allowedColumns = [
        'email',
        'password',
    ];

    /**
     * @param $data
     * @return bool
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function validate($data): bool
    {
        $this->errors = [];

        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        } else
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = "Email is not valid";
            }

        if (empty($data['password'])) {
            $this->errors['password'] = "Password is required";
        }

        if (empty($data['terms'])) {
            $this->errors['terms'] = "Please accept the terms and conditions";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}