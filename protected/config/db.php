<?php
/**
 * db configuration file
 * 
 * @author		Jackfiallos
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the development Web application configuration
 *
 **/
$db = array(
	'components' => array(
		'db' =>  array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=localhost;port=3306;dbname=celestic',
			'initSQLs'=>array('SET NAMES utf8'),
			'username' => 'root',
			'password' => 'mysqlubuntu',
			'charset' => 'utf8',
        	'tablePrefix' => '',
        	'emulatePrepare' => true,
        	'enableProfiling' => true,
        	'schemaCacheID' => 'cache',
        	'schemaCachingDuration' => 3600
		),
	),
);

return $db;