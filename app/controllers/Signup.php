<?php

declare(strict_types=1);

namespace Controller;

use Core\MainController;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class Signup
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

            if ($user->validate($_POST)) {
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $user->insert($_POST);
                redirect('login');
            }

            $data['errors'] = $user->errors;
        }

        $this->view('signup', $data);
    }
}
