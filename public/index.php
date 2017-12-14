<?php

namespace Yeedev;

error_reporting(E_ALL ^ E_NOTICE);
define(ROOT_PATH, str_replace("\\", '/', dirname(dirname(__FILE__))) . "/");

require_once ROOT_PATH . "src/" . "bootstrap.php";

try {
    $application = new Application();
    $application->main();
} catch (\Exception $e) {
    $application->log->error($e->getMessage());
}
