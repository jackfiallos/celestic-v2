<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Celestic',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'theme'=>'artemisa',

	// Lenguaje de los mensajes
	'sourceLanguage'=>'en_US',
	
	'localeDataPath'=>'protected/i18n/data/',

	// Codificacion default
	'charset'=>'iso-8859-1',

	// alias shortcodes
   	'aliases' => array(
        'widgets' => 'application.widgets',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'jack'
		),
        'documents',
        'milestones',
        'cases',
        'tasks',
        'tests'
	),

	// application components
	'components'=>array(
		'messages'=>array(
			'class'=>'CPhpMessageSource',
		),
		'user'=>array(
			'allowAutoLogin'=>true,
			'loginUrl'=>array('site/login'),
			'class' => 'ValidateUser',
		),
		'request' => array(
			'class' => 'CHttpRequest',
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
        ),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'caseSensitive'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=celestic',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'modules'=>array(
			'tasks'=>array(
				'title'=>'Tasks',
				'iconClass'=>'cogwheels'
			),
			'documents'=>array(
				'title'=>'Documents',
				'iconClass'=>'file'
			),
			'milestones'=>array(
				'title'=>'Milestones',
				'iconClass'=>'calendar'
			),
			'cases'=>array(
				'title'=>'Cases',
				'iconClass'=>'cogwheels'
			),
			'tests'=>array(
				'title'=>'Tests',
				'iconClass'=>'check'
			)
		),
		'languages'=>array(
			'en_us'=>array(
				'title'=>'English',
				'icon'=>'flag_usa.png'
			),
			'es_mx'=>array(
				'title'=>'Espa&ntilde;ol',
				'icon'=>'flag_mexico.png'
			),
			'es_es'=>array(
				'title'=>'Espa&ntilde;ol (Espa&ntilde;a)',
				'icon'=>'flag_spain.png'
			),
			'pt_br'=>array(
				'title'=>'Portugu&eacute;s',
				'icon'=>'flag_brazil.png'
			),
			'de_de'=>array(
				'title'=>'Denmark',
				'icon'=>'flag_germany.png'
			)
		),
	),
);