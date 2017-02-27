<?php

namespace Phpc\Models;

use Phalcon\Mvc\Model;

class Users extends Model
{
    public function initialize()
    {
    	$this->setConnectionService('mdb');
    }
}