<?php

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class Logout
{
	use Controller;

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
