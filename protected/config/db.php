<?php

$db = array(
	'components' => array(
		'db' =>  array(
			'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=celestic',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
            'charset' => 'latin1',
            'tablePrefix' => '',
            'emulatePrepare' => true,
            'enableProfiling' => true,
            'schemaCacheID' => 'cache',
            'schemaCachingDuration' => 3600
		),
	),
);

return $db;