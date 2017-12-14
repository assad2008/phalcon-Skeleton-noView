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
        return "hello world";
    }
}
