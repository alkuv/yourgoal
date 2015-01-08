<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
                        'admin.models.*',
			'admin.components.*',
                      'application.modules.profile.models.*',
		));
                
//                Yii::app()->setComponents(array(
//            'errorHandler' => array(
//                'errorAction' => 'admin/default/error',
//            ),
//            'user' => array(
//                'class' => 'CWebUser',
//              //  'stateKeyPrefix' => '_admin',
//                'loginUrl' => Yii::app()->createUrl($this->getId() . '/site/login'),
//            ),
//        ));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
                    $controller->layout = 'adminlogin';
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
