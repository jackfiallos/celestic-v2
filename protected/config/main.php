<?php
/**
 * main configuration file
 * 
 * @author		Jackfiallos
 * @link		http://qbit.com.mx/labs/celestic
 * @copyright 	Copyright (c) 2009-2013 Qbit Mexhico
 * @license		http://qbit.com.mx/labs/celestic/license/
 * @description
 * 
 * This is the main Web application configuration
 * CWebApplication properties can be configured here.
 *
 **/ 

// Load db config file
$db = include_once('db.php');

$main = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Celestic',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.models.forms.*',
		'application.components.*'
	),

	'theme'=>'artemisa',

	// Begin request event
    'onBeginRequest'=>array(
    	'Request','begin'
   	),

	// Lenguaje de los mensajes
	'sourceLanguage' => 'en',
	'language' => 'en_us',
	
	'localeDataPath'=>'protected/i18n/data/',

	// Codificacion default
	'charset'=>'utf-8',

	// alias shortcodes
   	'aliases' => array(
        'widgets' => 'application.widgets'
	),

	'modules'=>array(
        'documents',
        'milestones',
        'cases',
        'tasks',
        /*'tests',
        'install'*/
	),

	// application components
	'components'=>array(
		'messages'=>array(
			'class'=>'CPhpMessageSource'
		),
		'user'=>array(
			'allowAutoLogin'=>true,
			'loginUrl'=>array('site/login'),
			'class' => 'ValidateUser'
		),
		'request' => array(
			'class' => 'CHttpRequest',
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true
        ),
		'urlManager'=>array(
			'urlFormat'=>'get',
			'showScriptName'=>false,
			'caseSensitive'=>false,
			'rules'=>array(
				'<module:\w+>/'=>'<module>/default/index',
				'<module:\w+>/<action:\w+>'=>'<module>/default/<action>',
				'<action:\w+>'=>array('site/<action>'),
			)
        ),
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
			'itemTable'=>'stb_authItems',
			'assignmentTable'=>'stb_authAssignments',
			'itemChildTable'=>'stb_authItemChilds'
		),
		'errorHandler'=>array(
			'errorAction'=>'site/error'
		)
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// App parameters
		'appVersion'=>'0.4.1',
		'lastAppVersion'=>'0.4.0',
		// Email configuration
		'adminEmail'=>'erling.fiallos@qbit.com.mx',
		'multiplesAccounts'=>false,
		'mailSenderEmail'=>'celestic@qbit.com.mx',
		'mailSenderName'=>'Celestic',
		'mailHost'=>'smtp.qbit.com.mx',
		'mailSMTPAuth'=>true,
		'mailUsername'=>'qbitnoreply',
		'mailPassword'=>'n0r3plyqb1t',
		'mailSendMultiples'=>5,
		// Internationalization
		'timezone' => 'America/Mexico_City',
		'database_format'=>array(
			'date'=>'yyyy-MM-dd',
			'time'=>'HH:mm:ss',
			'dateTimeFormat'=>'{1} {0}'
		),
		'modules'=>array(
			'tasks'=>array(
				'title'=>'Tasks',
				'iconClass'=>'list'
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
			'tasks'=>array(
				'title'=>'Tasks',
				'iconClass'=>'tasks'
			),
			'tests'=>array(
				'title'=>'Tests',
				'iconClass'=>'check'
			)
		),
		'languages'=>array(
			'en_us'=>array(
				'title'=>'English',
				'icon'=>'flag_usa.png',
				'lang'=>'en_us'
			),
			'es_mx'=>array(
				'title'=>'Espa&ntilde;ol',
				'icon'=>'flag_mexico.png',
				'lang'=>'es_mx'
			),
			'es_es'=>array(
				'title'=>'Espa&ntilde;ol (Espa&ntilde;a)',
				'icon'=>'flag_spain.png',
				'lang'=>'es_es'
			),
			'pt_br'=>array(
				'title'=>'Portugu&eacute;s',
				'icon'=>'flag_brazil.png',
				'lang'=>'pt_br'
			),
			'de_de'=>array(
				'title'=>'Denmark',
				'icon'=>'flag_germany.png',
				'lang'=>'de_de'
			)
		)
	)
);

return CMap::mergeArray($main, $db);