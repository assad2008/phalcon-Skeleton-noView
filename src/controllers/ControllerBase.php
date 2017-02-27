<?php

namespace Phpc\Controllers;

use Phpc\Models\Users;
use Phalcon\Http\Request;

class ControllerBase extends \Phalcon\Mvc\Controller
{
	public $controller_name;
	public $action_name;
	public $input;
	public $output;

	public function onConstruct()
	{
		$this->controller_name = $this->router->getControllerName();
		$this->action_name = $this->router->getActionName();
		$this->input = new Request();
	}
}