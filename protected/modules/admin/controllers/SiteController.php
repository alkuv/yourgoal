<?php

class SiteController extends Controller
{
//	public $layout='column1';
public $layout='adminlogin';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
        	public function actionSetting()
	{
		$this->layout = 'adminmain';
		$model=new Options;
		if(isset($_POST['yt0']))
		{
			$arr = array('title' 		=> $_POST['title'],
						 'description'	=> $_POST['description'],
						 'keywords'		=> $_POST['keywords'],
						 'author'		=> $_POST['author'],
						 'charset'		=> $_POST['charset'],
					);
			
			foreach($arr as $key => $value)
			{
				Options::model()->updateAll(array("value" => $value), "name='" . $key . "'");
				
			}
			
			Yii::app()->user->setFlash('success','Updated successful!');
			$this->refresh();
		}
		$this->render('setting',array('model'=>$model));
	}
        
        public function actionIndex()
	{
		$this->layout = 'adminmain';             
		if(isset(Yii::app()->user->user_id))
		$this->render('index');
		else
		$this->redirect('login');

	}
        public function actionBackground()
	{
            $model=new Options;
		$this->layout = 'adminmain';
		if(isset($_POST['yt0']))
		{
			//$logo=CUploadedFile::getInstance($model,'image');
			//$logo->saveAs('');
			
			$arr = array('background'	=> $_POST['colorpicker'],
						 'logo'			=> 'logo.png',
					);
			
			foreach($arr as $key => $value)
			{
				Options::model()->updateAll(array("value" => $value), "name='" . $key . "'");
				
			}
		}
		// display the background form
		$this->render('background',array('model'=>$model));
	}
    public function actionForgot()
	{
		$model=new User('forgot');

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='forgot-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['Users']))
		{
			if($model->forgot($_POST['Users']['username'])==false)
			Yii::app()->user->setFlash('invalid', '<div class="err">Email ID Not Found! Please Try Again.</div>');
			else
			Yii::app()->user->setFlash('success', '<div class="msg">Your password has been changed and new password has been sent in given email.</div>');
			
		}
		// display the forgot form
		$this->render('forgot',array('model'=>$model));
	}
        public function actionChangePassword()
	{
		$model=new User();
		$this->layout = 'adminmain';
		if(isset($_POST['button'])=='Update')
		{
//			$cnt=$model->countByAttributes(array('user_id'=>1, 'password'=>md5($_POST['oldpass']))); 
//			if($cnt==1)
//			{
//				if($_POST['newpass']!=$_POST['newcpass'])
//				{
//					Yii::app()->user->setFlash('error','New Password and Confirm Password mismatch.');
//				}
//				else
//				{
//					$connection=Yii::app()->db;
//					$sqlnew="update users set password='" . md5($_POST['newpass']) . "' where user_id=1"; 
//					$connection->createCommand($sqlnew)->execute();
//					Yii::app()->user->setFlash('success','Password changed successfully.');
//				}
//			}
//			else
//			{
//				Yii::app()->user->setFlash('error','Invalid old password.');
//			}
		}
		$this->render('changePassword', array('model'=>$model));

	}
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
            $this->render('test');
//		$model=new ContactForm;
//		if(isset($_POST['ContactForm']))
//		{
//			$model->attributes=$_POST['ContactForm'];
//			if($model->validate())
//			{
//				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
//				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
//				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
//				$this->refresh();
//			}
//		}
//		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
            // echo Yii::app()->getBaseUrl();
          //echo  Yii::app()->homeUrl;
             $this->layout='adminlogin';
//		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
//			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

		$model=new LoginForm;

		// if it is ajax validation request
//		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
//		{
//			echo CActiveForm::validate($model);
//			Yii::app()->end();
//		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
                     // echo '<pre>'; print_r($model); echo '</pre>'; die();
			if($model->validate() && $model->login()) {
                          
				$this->redirect(Yii::app()->getBaseUrl()."/index.php/admin/site/Index");
                                
                                }
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
                $this->redirect(Yii::app()->getBaseUrl()."/index.php/admin/site/Index");
		//$this->redirect(Yii::app()->homeUrl);
	}
}
