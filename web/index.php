<?php

define ('DS'   , DIRECTORY_SEPARATOR);
define ('ROOT' , dirname (dirname (__FILE__)));

require_once ROOT . DS . 'vendor' . DS . 'autoload.php';

$proxyApp = \Starter\App\Proxy::instance ();
$proxyApp->defineApp (new \Starter\App\Slim ())->executeApp ();