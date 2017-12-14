<?php

namespace Yeedev\Controllers;

use Yeedev\Controllers\ControllerBase;

class IndexController extends ControllerBase
{

    public function initialize()
    {

    }

    public function indexAction()
    {
        $this->twig->assign("hello", "hello world");
        $this->twig->display("index.html");
    }
}
