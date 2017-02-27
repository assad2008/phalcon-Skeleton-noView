<?php

namespace Phpc;

error_reporting(E_ALL ^ E_NOTICE);

use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url;
use Phalcon\Http\Response;
use Phalcon\Http\Request;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Session\Adapter\Redis;
use Phalcon\Db\Adapter\Pdo\Mysql as Database;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Mvc\Application as BaseApplication;
use Phalcon\Mvc\Model\Metadata\Memory as MemoryMetaData;

define(BASEDIRS, str_replace("\\", '/', dirname(dirname(__FILE__))) . "/");

class Application extends BaseApplication
{
    protected function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces([
                'Phpc\Controllers' => BASEDIRS . 'src/controllers/',
                'Phpc\Models'      => BASEDIRS . 'src/models/'
            ]
        );
        $loader->registerFiles([
        		BASEDIRS . "vendor/autoload.php"
        	]
        );
        $loader->register();
    }

    protected function registerServices()
    {
        $di = new DI();

        $di->set('router', function () {
            $router = new Router();
            $router->add("/",["controller" => "index","action" => "index"]);
            $router->notFound(["controller" => "","action" => ""]);
			$router->setDefaultController("index");
			$router->setDefaultAction("index");
            return $router;
        });

        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Phpc\Controllers');
            return $dispatcher;
        });

        $di->set("log",function (){
            $log = $logger = new FileAdapter(BASEDIRS . 'data/logs/syslog/' . date("Y-m-d"). '.log');
            return $log;
        });

        $di->set('response', function () {
            return new Response();
        });

        $di->set('input', function () {
            return new Request();
        });

        $di->set('view', function () {
            $view = new View();
            return $view;
        });

        $di->set("url",function(){
            return new Url();
        });

        $di->set('mdb', function () { //主库
            return new Database(
                [
                    "host"     => "localhost",
                    "username" => "",
                    "password" => "",
                    "dbname"   => ""
                ]
            );
        });

        $di->set('sdb', function () {  //从库
            return new Database(
                [
                    "host"     => "localhost",
                    "username" => "",
                    "password" => "",
                    "dbname"   => ""
                ]
            );
        });

        $di->set("sess",function(){
             $session = new Redis([
                 'uniqueId'   => 'phpc_uuid',
                 'host'       => '127.0.0.1',
                 'port'       => 6000,
                 'persistent' => false,
                 'lifetime'   => 86400,
                 'prefix'     => 'phpc_sess_',
             ]);
             $session->start();
             return $session;
        });

        $di->set('modelsMetadata', function () {
            return new MemoryMetaData();
        });

        $di->set('modelsManager', function () {
            return new ModelsManager();
        });

        $this->setDI($di);
    }

    public function main()
    {
        $this->registerServices();
        $this->registerAutoloaders();
        echo $this->handle()->getContent();
    }
}

try {
    $application = new Application();
    $application->main();
} catch (\Exception $e) {
    $application->log->error($e->getMessage());
}
