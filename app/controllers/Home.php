<?php

declare(strict_types=1);

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class Home
{
    use MainController;

    /**
     * @return void
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function index(): void
    {
        $data['username'] = isset($_SESSION['USER']) && !empty($_SESSION['USER']->email)
            ? $_SESSION['USER']->email
            : 'User';

        $this->view('home', $data);
    }
}
