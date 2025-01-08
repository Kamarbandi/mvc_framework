<?php

declare(strict_types=1);

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class Home
{
    use Controller;

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
