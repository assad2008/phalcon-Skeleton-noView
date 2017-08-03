<?php
/**
 *
 * @authors Assad (rlk002@gmail.com)
 * @date    2017-04-14 11:49:08
 * @version $Id$
 */

return new \Phalcon\Config([
    "application" => [
        "controllersDir" => ROOT_PATH . 'src/controllers/',
        "modelsDir" => ROOT_PATH . 'src/models/',
    ],
    "mdb" => [
        "host" => "127.0.0.1",
        "username" => "root",
        "password" => "root123654",
        "dbname" => "",
    ],
    "udb" => [
        "host" => "127.0.0.1",
        "username" => "root",
        "password" => "root123654",
        "dbname" => "",
    ],
    "redis" => [
        "host" => "127.0.0.1",
        "port" => 6379,
        "persistent" => false,
        "index" => 0,
    ],
    "cachelifetime" => 3600,
    "logopath" => ROOT_PATH . 'data/logs/syslog/' . date("Y-m-d") . '.log',
    "uploadpath" => ROOT_PATH . "data/upload/",
]);
