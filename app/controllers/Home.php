<?php

namespace Controller;

defined('ROOT_PATH') or exit('Access Denied!');

/**
 * home class
 */
class Home
{
    use MainController;

    public function index()
    {
        $this->view('home', ['title' => 'Home']);
    }
}
