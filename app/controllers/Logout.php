<?php

namespace Controller;

use Core\MainController;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class Logout
{
	use MainController;

    /**
     * @return void
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
	public function index()
	{
		if(!empty($_SESSION['USER']))
			unset($_SESSION['USER']);

		redirect('home');
	}
}
