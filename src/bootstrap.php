<?php

/**
 * @Filename: bootstrap.php
 * @Author: assad
 * @Date:   2017-08-16 10:22:44
 * @Synopsis: 核心启动文件
 * @Version: 1.0
 * @Last Modified by:   assad
 * @Last Modified time: 2017-12-14 18:07:24
 * @Email: rlk002@gmail.com
 */

namespace Yeedev;

use Phalcon\Cache\Backend\Redis as Rediscache;
use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Db\Adapter\Pdo\Mysql as Database;
use Phalcon\DI;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Loader;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Mvc\Application as BaseApplication;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Mvc\Model\Metadata\Memory as MemoryMetaData;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Session\Adapter\Redis;

class Application extends BaseApplication
{
    protected $config;

    public function __construct()
    {
        $this->config = require ROOT_PATH . "src/config/config.php";
    }

    protected function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerFiles(
            [
                ROOT_PATH . "vendor/autoload.php",
            ]
        );
        $loader->registerNamespaces(
            [
                'Yeedev\Controllers' => $this->config->application->controllersDir,
                'Yeedev\Models' => $this->config->application->modelsDir,
            ]
        );
        $loader->register();
    }

    protected function registerServices($config)
    {
        $di = new DI();

        $di->set('router', function () {
            $router = new Router();
            return $router;
        });

        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Yeedev\Controllers');
            return $dispatcher;
        });

        $di->set("log", function () use ($config) {
            $logger = new FileAdapter($config->logopath);
            return $logger;
        });

        $di->set('response', function () {
            return new Response();
        });

        $di->set('request', function () {
            return new Request();
        });

        $di->set('view', function () {
            $view = new View();
            return $view;
        });

        $di->set("url", function () {
            return new Url();
        });

        $di->set('mdb', function () use ($config) {
            //主库
            return new Database(
                [
                    "host" => $config->mdb->host,
                    "username" => $config->mdb->username,
                    "password" => $config->mdb->password,
                    "dbname" => $config->mdb->dbname,
                ]
            );
        });

        $di->set("udb", function () use ($config) {
            //主业务库
            return new Database(
                [
                    "host" => $config->udb->host,
                    "username" => $config->udb->username,
                    "password" => $config->udb->password,
                    "dbname" => $config->udb->dbname,
                ]
            );
        });

        $di->set("cache", function () use ($config) {
            $frontCache = new FrontData(
                [
                    "lifetime" => $config->cachelifetime,
                ]
            );
            $cache = new Rediscache(
                $frontCache,
                [
                    "host" => $config->redis->host,
                    "port" => $config->redis->port,
                    "persistent" => $config->redis->persistent,
                    "index" => $config->redis->index,
                ]
            );
            return $cache;
        });

        $di->set("sess", function () use ($config) {
            $session = new Redis([
                'uniqueId' => 'phpc_uuid',
                'host' => $config->redis->host,
                'port' => $config->redis->port,
                'persistent' => $config->redis->persistent,
                'lifetime' => 86400,
                'prefix' => 'phpc_sess_',
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

        $di->set("config", function () use ($config) {
            return $config;
        });

        $this->setDI($di);
    }

    public function main()
    {
        $this->registerAutoloaders();
        $this->registerServices($this->config);
        echo $this->handle()->getContent();
        exit(0);
    }
}
