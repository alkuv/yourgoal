<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
return array(
        //installing the theme
        'theme'=>'yours-goal',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'YOURGOAL',
        'defaultController'=>'home',#user
      // 'language' => 'ru',
	// preloading 'log' component
	'preload'=>array('log'),
	    // path aliases
 

	// autoloading model and component classes
	'import'=>array(
            //yii user management module
            'application.modules.admin.models.*',
                'application.modules.user.models.*',
		'application.models.*',
		'application.components.*',
	),
        
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
                //user management module
                'user' => array(
                    'debug' => false,
                    'userTable' => 'user',
                    'loginType' => 3,
                ),
                'friendship' => array(
                    'friendshipTable' => 'friendship',
                ),
                'profile' => array(
                    'privacySettingTable' => 'privacysetting',
                    'profileTable' => 'profile',
                    //'profileCommentTable' => 'profile_comment',
                    'profileVisitTable' => 'profile_visit',
                ),
                'registration' => array(
//                    'registrationUrl'  => array('/Registration/registration'),
//                    'registrationView' => array('/views/registration'),
                ),
                'avatar' => array(),
             'admin'=>array( 'layoutPath' => 'protected/modules/admin/layouts',
            'layout' => 'adminmain',
            'defaultController' => 'site'),
	),

	// application components
	'components'=>array(
		'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        //yii user management module authentications
                        'class' => 'application.modules.user.components.YumWebUser',
                        'loginUrl' => array('//user/user/login'),
		),
                'cache' => array('class' => 'system.caching.CDummyCache'),
		// uncomment the following to enable URLs in path-format
                 'urlManager'=>array(
        'urlFormat'=>'path',
        'rules'=>array(
			''=>'home/',
			'blog/<alias>' => 'blogposts/view',
			'blog/' => 'blogposts/index',
            '<controller:\w+>/<id:\d+>'=>'<controller>/view',
            '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>' ,
            'admin/<controller:\w+>/<action:\w+>/<id:\d+>' => 'admin/<controller>/<action>' ,
            'blog/<alias>' => '/blogposts/view',
        ),
), 
//		'urlManager'=>array(
//			'urlFormat'=>'path',
//			'rules'=>array(
//                                'gii'=>'gii',
//                                'gii/<controller:\w+>'=>'gii/<controller>',
//                                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
//				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
//				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//			),                        
//                        'showScriptName'=>false,
//                        'caseSensitive'=>false,
//		)
            
		// uncomment the following to use a MySQL database
//		'db'=>array(
//			'connectionString' => 'mysql:host=localhost;dbname=yours-goal',
//			'emulatePrepare' => true,
//			'username' => 'root',
//			'password' => '',
//			'charset' => 'utf8',
//                        'tablePrefix' => '',//USED BY YII USER MANAGEMENT
//		),
                // uncomment the following to use a MySQL database #####DB LIVE SETTINGS##############
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yourgoal',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
                        'tablePrefix' => '',//USED BY YII USER MANAGEMENT
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
		'adminEmail'=>'aronasoft@gmail.com',
                'commentNeedApproval'=>true,
                //fb app id
                'fb_app_id'=>'1496929280588809'
	),
);