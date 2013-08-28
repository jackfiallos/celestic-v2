<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii-1.1.12.b600af/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

$configFile = (YII_DEBUG==true) ? 'dev.php' : 'production.php';

require_once($yii);
Yii::createWebApplication($config . $configFile)->run();
