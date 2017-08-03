<?php

namespace Phpc\Controllers;

use Phpc\Controllers\ControllerBase;

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
