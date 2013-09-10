<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Nissen Idea',
	'theme'=>'abound',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		//'application.modules.user.models.*',
        //'application.modules.user.components.*',
		//'application.modules.rights.*',
		//'application.modules.rights.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		 
		/*'user'=>array(
                'tableUsers' => 'ni_users',
                'tableProfiles' => 'ni_profiles',
                'tableProfileFields' => 'ni_profiles_fields',
        ),
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'sjm120182',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1', '198.58.102.255'),
		),*/
		/*'rights'=>array(
			'install'=>true,
		),*/
	),
	'homeUrl' => 'http://example.com',

	// application components
	'components'=>array(
		'user'=>array(
            //'class'=>'RWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            //'loginUrl'=>array('/user/login'),
		),
		// uncomment the following to enable URLs in path-format
		'authManager'=>array(
				'class'=>'CDbAuthManager',
				'connectionID'=>'db',
				'defaultRoles'=>array('authenticated', 'guest'),
			    //'itemTable'=>'ni_AuthItem',
			    //'itemChildTable'=>'ni_AuthItemChild',
			    //'assignmentTable'=>'ni_AuthAssignment',
			),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				''=>'combinationEngine/index',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/**//*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=nissenidea.com',
			//'emulatePrepare' => true,
			'username' => 'admin',
			'password' => '123!!@qwe',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		/*'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),*/
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	// trace statement: echo Yii::trace(CVarDumper::dumpAsString($Cstring),'comment_here');
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'sjmolinski@gmail.com',
		//'root'=> 'http://localhost/fuzzy-octo-hipster/',
		'root'=> 'http://nissenidea.com/',
		'engine'=> 'Mega Sena',
	),
);