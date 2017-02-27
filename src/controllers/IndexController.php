<?php

namespace Phpc\Controllers;

use Phpc\Controllers\ControllerBase;

class IndexController extends ControllerBase
{
	public $test;

	public function initialize()
	{
		$this->test = "is test";
	}

	public function indexAction()
	{
		debug($this->input->getLanguages());	
	}
}