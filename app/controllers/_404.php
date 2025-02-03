<?php 

namespace Controller;

defined('ROOT_PATH') OR exit('Access Denied!');

class _404
{
	use MainController;
	
	public function index()
	{
		$this->view('404');
	}
}
