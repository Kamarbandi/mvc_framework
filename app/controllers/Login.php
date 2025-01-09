<?php

declare(strict_types=1);

namespace Controller;

use Model\User;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class Login
{
    use MainController;

    /**
     * @return void
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function index(): void
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $user = new User;
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if ($email && !empty($password)) {
                $row = $user->first(['email' => $email]);

                if ($row && password_verify($password, $row->password)) {
                    $_SESSION['USER'] = $row;
                    redirect('home');
                    return;
                } else {
                    $user->errors['email'] = "Wrong email or password";
                }
            } else {
                $user->errors['email'] = "Please enter a valid email and password";
            }

            $data['errors'] = $user->errors;
        }

        $this->view('login', $data);
    }
}
