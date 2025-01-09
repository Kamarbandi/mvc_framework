<?php

namespace Controller;

use Core\MainController;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class NotFound
{
	use MainController;

    /**
     * @return void
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
	public function index()
	{
		echo "404 this Controller Not Found";
	}
}
