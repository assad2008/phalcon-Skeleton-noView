<?php

namespace Phpc\Controllers;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    public $controller_name;
    public $action_name;
    public $input;
    public $output;
    public $config;

    public function onConstruct()
    {
        $this->controller_name = $this->router->getControllerName();
        $this->action_name = $this->router->getActionName();
        $this->input = $this->di->get("request");
        $this->output = $this->di->get("response");
        $this->config = $this->di->get("config");
    }
}
