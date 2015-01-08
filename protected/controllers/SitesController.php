<?php
Yii::import('application.vendors.*');
require_once 'googleplus/src/Google_Client.php';
require_once 'googleplus/src/contrib/Google_Oauth2Service.php';
class SitesController extends Controller
{
	public $layout='column1';

                        public function filters()
                            {
                                return array(
                                    'accessControl', // perform access control for CRUD operations
                                );
                            }   
        
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

//        public function accessRules()
//	{ 
//                if(isset(Yii::app()->user->roles)) 
//                {
//                        if(Yii::app()->user->roles == "admin")
//                        {
//                            $arr = array('dashboard','error','test','logout','admin','saverole','myaccount');
//                        }
//		        else if( Yii::app()->user->roles == "user")
//			{
//                            $arr = array('dashboard','error','test','logout','user','saverole','myaccount');
//			}
//		        else if( Yii::app()->user->roles == "artist")
//			{
//                            $arr = array('dashboard','error','test','logout','artist','saverole','myaccount','create_artwork');
//			}
//                        else 
//                        {
//                            $arr=array('logout','dashboard','saverole');
//                        }
//	        }
//                else 
//                {
//                    $arr=array('logout');
//                }
//		return array(
//			array('allow',
//				'actions'=>$arr,
//				'users'=>array('@'),
//			),
//			array('allow',
//				'actions' => array('Google_login','test','error','facebook','twitter_oauth','twitter'),
//				'users' => array('*'),
//			),
//                        array('allow',
//				'actions' => array('login','forgotpassword','sendpassword','register'),
//				'users' => array('?'),
//			),
//			array('deny',  // deny all users anything not specified
//			 'users'=>array('*'),
//			),
//		);
//	}
       
        
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
         // echo $error['message']; die("---edieee");
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
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
      public function actionLogin()
	{
		$baseurl  = Yii::app()->request->baseUrl;
                $model=new LoginForm;
              
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
                       
			 $model->attributes=$_POST['LoginForm'];
                         Yii::app()->session['username']=$_POST['LoginForm']['email']; 
                         Yii::app()->session['password']=$_POST['LoginForm']['password']; 
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
                          
                          $this->redirect(array('site/dashboard'));
                          //$this->redirect(array('site/welcomeuser')); 
                        
                        }
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
        
        public function actionDashboard()
        {
             $id = Yii::app()->user->id;
             $detail=UserDetail::model()->findByAttributes(array('id'=>$id)); 
             //echo "<pre>"; print_r($detail->roles); exit;
             if($detail->roles == '')
             {
                 $fill_role = '';
             }
             else
             {
                 $fill_role = $detail->roles;
             }
             $this->render('dashboard',array('fill_role'=>$fill_role));
        }
        
        public function actionsaverole()
        {
            if(isset($_POST['role']))
            {
                $id = Yii::app()->user->id;
                $detail=UserDetail::model()->findByAttributes(array('id'=>$id));
                $detail->roles = $_POST['role'];
                $detail->save(false);
                Yii::app()->user->setState('roles',$detail->roles);
            }
            $this->redirect('dashboard');
        }
        
        public function actionmyaccount()
        {
            $id = Yii::app()->user->id;
            $detail=UserDetail::model()->findByAttributes(array('id'=>$id));
            //echo "<pre>"; print_r($_POST); exit;   
            $error = '';
            if(isset($_POST['UserDetail']['email']))
            {  
		$username = $_POST['UserDetail']['username'];
                $email = $_POST['UserDetail']['email'];
                $location = $_POST['UserDetail']['location'];
                
                $detail->username =  $username;
                $detail->email =  $email;
                $detail->location =  $location;
                
                if($_POST['UserDetail']['newpassword'] != '')
                { 
                    if($_POST['UserDetail']['newpassword'] != $_POST['UserDetail']['cpassword'])
                    {
                        $error = 'Please match the passwords';
                    }
                    else
                    {
                        $detail->password =  md5($_POST['UserDetail']['newpassword']);
                    }
                }
                            
		if($error == '' && $detail->save(false))
                {
                    Yii::app()->user->setFlash('success', "Your account is updated.");
                    $this->redirect(array('dashboard'));
                }		
	    }
            $this->render('myaccount',array('detail'=>$detail,'error'=>$error));
        }
        
        public function actionforgotpassword()
        {
            $error = '';
            $success = '';
            if(isset($_POST['email']))
            {
                $email=$_POST['email'];
                $model = UserDetail::model()->findByAttributes(array('email'=>$email));
                //echo '<pre>'; print_r($model); die("record");
                if(empty($model))
                {
                   $error = 'Email Doesnot Exist';
                }
                else
                {
                        $headers = "";
                        $headers .= 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'From: Admin <no-reply@ekspose.com';
                        $to = $email;
                        $subject  = 'Reset Password Link - Ekspose';
                        $msg = '<div style="padding-top: 50px; width:536px;padding-left: 44px; min-height: 325px; background-color: #fff;">
                                    Here is your password link.
                                    <br>
                                    Please click on the link below to get your new password.<br>
                                    <br>
                                    <a target="_blank" href="'.Yii::app()->params["siteurl"].'/index.php/site/sendpassword?email='.$email.'" style="color:#fBB339; text-decoration:none;">Get Password</a>
                                    <br><br>
                                    Thank you for choosing <span style="color:#fBB339"><a href="'.Yii::app()->params["siteurl"].'/" style="color:#fBB339; text-decoration:none;">ekspose</a></span><br>
                                    <br>
                                    Sincerely,<br>
                                    <span style="color:#fBB339">Team <a href="'.Yii::app()->params["siteurl"].'/" style="color:#fBB339; text-decoration:none;">ekspose.com</a></span><br>
                                    <br>
                                    <br></span></span>
                                </div>';
                        mail($to,$subject,$msg,$headers);
                                        
                 $success = 'New password link sent to your email account.';
                }
                $this->render('forgotpassword',array('error'=>$error,'success'=>$success));
                exit;
            }

            $this->render('forgotpassword',array('error'=>$error));
        }
        
        public function actionsendpassword($email=null)
        {
            $error = 'Not a valid request to get the password.';
            if(isset($_GET['email']))
            {
                $email=$_GET['email'];
                $model = UserDetail::model()->findByAttributes(array('email'=>$email));
                //echo '<pre>'; print_r($model); die("record");
                if(empty($model))
                {
                   $error = 'Email Doesnot Exist';
                }
                else
                {
                        $headers = "";
                        $headers .= 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'From: Admin <no-reply@ekspose.com';
                        $to = $email;
                        $subject  = 'New Password - Ekspose';
                        
                        // set new password
                        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $randomString = '';
                        for ($i = 0; $i < 6; $i++)
                        {
                         $randomString .= $characters[rand(0, strlen($characters) - 1)];
                        }
                        
                        $password=$randomString;
                        $hashpassword = md5($randomString);
                        $model->password=$hashpassword;
                        $model->save(false);
                        //echo '<pre>'; print_r($password); die(" -----record");
                        
                        $msg = '<div style="padding-top: 50px; width:536px;padding-left: 44px; min-height: 325px; background-color: #fff;">
                                    Here is your new password.
                                    <br>
                                    Please keep this information safe as it contains your Email and Password.<br>
                                    <br>
                                    Your Account Info:<br>
                                    <span style="color:#206ABF">E-mail : '.$email.'<br>
                                    Password : '.$password.'.<br>
                                    <br><br>
                                    Thank you for choosing <span style="color:#fBB339"><a href="'.Yii::app()->params["siteurl"].'/" style="color:#fBB339; text-decoration:none;">ekspose</a></span><br>
                                    <br>
                                    Sincerely,<br>
                                    <span style="color:#fBB339">Team <a href="'.Yii::app()->params["siteurl"].'/" style="color:#fBB339; text-decoration:none;">ekspose.com</a></span><br>
                                    <br>
                                    <br></span></span>
                                </div>';
                        //mail($to,$subject,$msg,$headers);
                        $success = 'New password is sent to your email account.';
                        $this->render('sendpassword',array('success'=>$success));
                        exit;
                }
            }
            $this->render('sendpassword',array('error'=>$error));
        }
        
        public function actionregister()
	{
            $detail = new Register;
            $error = '';
            //echo "<pre>"; print_r($_POST); exit;
            if(isset($_POST['Register']['email']))
            {
                $detail->attributes=$_POST['Register'];
                $detail->password = md5($_POST['Register']['password']);
                if($detail->save())
                {
                    $success = 'You have been registered successfully.Please check your email to activate your account.';
                    $this->render('register',array('detail'=>$detail,'success'=>$success));
                    exit;
                }
	    }
            $this->render('register',array('detail'=>$detail,'error'=>$error));
        } 
                
         public function actionartist()
         {
             $this->render('artist');
         }
         
         public function actionadmin()
         {
             $this->render('admin');
         }
         
         public function actionuser()
         {
             $this->render('user');
         }
         
         public function actioncreate_artwork()
         {
             $this->render('create_artwork');
         }

         public function actionProfile()
                {  
              
                  $host=$_SERVER['HTTP_HOST'];             
                  $hostarray = explode(".", $host);
                  $currentactiveuser=$hostarray[0];
                 
                  $model=UserDetail::model()->findByAttributes(array('choosen_username'=>$currentactiveuser));  
          
                  if(!empty($model))
                  {
                         Yii::app()->session['record']=$model; 
                         $this->render('profile',array('model'=>$model));
                  }
                else{
                      $userid = Yii::app()->user->getID(); 
                      $model = UserDetail::model()->findByPk("$userid");
                      $this->render('profile',array('model'=>$model));
                    }
             
                 
                }
                 public function actionPortfolio()
                        {  $model=new Portfolio;
                     
                 if(!empty($_FILES) && $_FILES['file']['tmp_name'] != '')
                     
                     {
                           $file = CUploadedFile::getInstanceByName('file');

                            if(is_object($file) && get_class($file)== 'CUploadedFile')
                            {   $userid = Yii::app()->user->getID();
                                $model->image  = time().$file->name;
                                $file->saveAs('images/slides/'.$model->image);
                                $model->title = $_POST['title'];
                                $model->desc    = $_POST['description'];
                                $data=Yii::app()->session['record'];
                                $model->user_id=$data->id;
                                $model->save(false);
                                $this->redirect(array('site/Profile'));
                            }
                     }
                            
                        }
        public function actiontest()
        {   // phpinfo();
        
              $this->render('test');
        }
      
        public function actionwelcomeuser()
        {     
           $userid = Yii::app()->user->getID();     
           $user_detail = UserDetail::model()->findByPk("$userid");
           $chossenname=$user_detail->choosen_username;
           
         //  echo $chossenname; die("edddieee");
            if(empty($chossenname))
                {
                 $this->render('welcomeuser',  array('model'=>$user_detail));
                }
               else 
                   {
                    $doaminname=$user_detail->domain_name;
                    $path=$doaminname.'/index.php/site/Profile';
                    $this->redirect($path);
                //   echo '<pre>';print_r($user_detail); die("eddie");
                  //  $this->redirect(array('site/Profile'));
                
                   }
          
       }
       
        public function actionSearchUser()
               {    $userid = Yii::app()->user->getID();
                    $Choosen_username=strtolower($_REQUEST['choosen_username']);                  
                    $userdetail=UserDetail::model()->findByAttributes(array('choosen_username'=>$Choosen_username)); 
                    if(empty($userdetail))
                        {
                           $domainname="http://".$Choosen_username.".".Yii::app()->params['siteurl']; 
                           $userinfo = UserDetail::model()->findByPk("$userid");                           
                           $userinfo->choosen_username=$Choosen_username;
                           $userinfo->domain_name=$domainname;
                          // $userinfo->cookie=$_COOKIE['PHPSESSID'];                           
                           $userinfo->save(false);
                          // Yii::app()->SESSION['successfully']='Success';
                           $res['domain_name']=$domainname;
		
		           echo json_encode($res);
                           exit;                                               
                        }
                        else 
                            {
                            
                                 echo 2;
		                 exit;
                            }
               }
               /**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		//Yii::app()->user->logout();
		//$this->redirect(Yii::app()->params['logout']);
               //echo Yii::app()->SESSION['Logout_facebook']; die("eddie");
               if(isset(Yii::app()->SESSION['Logout_facebook']))
		{
                  
			$baseurl  = Yii::app()->request->baseUrl;
			Yii::import('application.vendors.*');
			require_once 'facebook/facebook.php';
			$config = array(
				'appId' => '581861355195258',
				'secret' => '9d06e9ffe7bdbb8bd1d6eec889b512c5',
			);
			$facebook = new Facebook($config);
			$access_token=Yii::app()->SESSION['access_token'];
			if ($facebook->getUser())
			{
				try
				{
					$me = $facebook->api('/me');
				}
				catch(FacebookApiException $e)
				{
					$facebook->destroySession();
				}
			}
			$logoutpath=$facebook->getLogoutUrl();
                        //echo $logoutpath; die("eddie");
			Yii::app()->user->logout();			
			unset(Yii::app()->SESSION['Logout_facebook']);
                        $this->redirect($logoutpath);
			//header("Location: ".$logoutpath);
		}
                elseif
		(Yii::app()->SESSION['Logout_googleplus'])
			{  

                            $website3 =Yii::app()->params['logout'];
                            $website="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=$website3";
                            $google_client_id  = '664015273073.apps.googleusercontent.com';
                            $google_client_secret  = 'aXDlmu9KGnxHNefqf9NJJekX';
                            $google_redirect_url  = 'http://localhost/yii/invision/index.php/site/google_login/oauth2callback';
                            $google_developer_key  = 'AIzaSyD_xbtQSj10NPHNWanw_2AZwANuqfn0wRI';
                            $gClient = new Google_Client();
                            unset($_SESSION['token']);
                            $gClient->revokeToken();
                            Yii::app()->user->logout();
                            unset(Yii::app()->session['membership']);
                            unset(Yii::app()->session['Logout_google']);
                            header('Location: '. $website);
		}
            else
		{                
			if
			($_COOKIE)
				{
                                //unset($_COOKIE['fbsr_224146264393498']); 
                                unset($_COOKIE['PHPSESSID']);
			}
			unset($_SESSION['oauth_token']);
			unset($_SESSION['oauth_token_secret']);
			unset ($_SESSION['access_token']);
                      
			unset(Yii::app()->SESSION['Logout_twiiter']);
			Yii::app()->user->logout();
			unset(Yii::app()->session['membership']);
			$websit = Yii::app()->params['siteurl'];
			header('Location: '. $websit);
		}
                
	}
                
       public function actionfacebook()
       {                
                   echo"eddie";     $baseurl  = Yii::app()->request->baseUrl;
                   
                        Yii::import('application.vendors.*');
                        require_once 'facebook/facebook.php';
                        $config = array(
                                'appId' => '531456833621778',
                                'secret' => '771075837a307cd2cb084d0317cf8a55',

                        );
                       

		
		# Let's see if we have an active session
		$facebook = new Facebook($config);
		$user_id = $facebook->getUser();
		$access_token = $facebook->getAccessToken();
		Yii::app()->SESSION['access_token']=$access_token;		

		
		if
		(!empty($user_id))
		{
			# Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
			try{
				$uid  = $facebook->getUser();
				$user = $facebook->api('/me/friends');
				$my_information = $facebook->api('/me');
                              //  echo '<pre>'; print_r($my_information); die("eddie");
                            
			
			} catch (Exception $e)
			{}

			if
			(!empty($my_information))
			{
                             Yii::app()->SESSION['my_information']=$my_information;
                             $usertable = UserDetail::model()->findByAttributes(array(), 'facebook_id =:value OR email =:value2', array(':value'=>$my_information['id'], ':value2' => $my_information['email']));
                            if(empty($usertable))
                                {
                                     $password =md5($my_information['id']) ;  
                                     $model = new UserDetail;
                                     $model->username           = $my_information['username'];			            
			             $model->email              = trim($my_information['email']);
                                     $model->password              = $password;
                                     $model->facebook_id        = $my_information['id'];    
                                     //$model->roles              ="user";
                                     if(isset($my_information["location"])) 
                                    {  
                                      $location=trim($my_information["location"]["name"]);
                                      $model->location        = $location; 
                                    }
                                      
                                     $model->save(false);                                                       
                              
                                     $email     = trim($my_information['email']);
                                      $models  = new LoginForm;
                                      if(isset($my_information))
                                        {
                                                $models->email=trim($my_information['email']);						
						$record=UserDetail::model()->findByAttributes(array('email'=>$my_information['email']));
                                                $models->password=$record['password'];                                                						
						if($models->validate() && $models->login())
						{  
                                                     Yii::app()->SESSION['Logout_facebook']="logout";
                                                     $this->redirect(array('site/dashboard'));
                                                    // die("afterlogin");
                                                    // $this->redirect(array('site/welcomeuser'));
                                                 
                                                }
                                        }
                                        
                                }
                            else {  
                                      $email     = trim($my_information['email']);
                                  if(isset($my_information["location"])) 
                                    {  
                                      $model2=UserDetail::model()->findByAttributes(array('email'=>$email));
                                      $location=trim($my_information["location"]["name"]);
                                      $model2->location        = $location; 
                                      $model2->save(false);
                                    }
                                      $models=new LoginForm;
                                    
                                      if(isset($my_information))
                                        {
                                                $models->email=trim($my_information['email']);						
						$record=UserDetail::model()->findByAttributes(array('email'=>$my_information['email']));
                                                $models->password=$record['password'];                                                						
						if($models->validate() && $models->login())
						{   
                                                    Yii::app()->SESSION['Logout_facebook']="logout";
                                                   // die("afterlogin");
                                                    $this->redirect(array('site/dashboard'));
                                                  //   $this->redirect(array('site/welcomeuser'));
                                                
                                                }
                                        }
                         }
		
                          
			} else
			{
				# For testing purposes, if there was an error, let's kill the script
				die("There was an error.");
			}
		}
		else
		{
			# There's no active session, let's generate one
			$login_url = $facebook->getLoginUrl(array('scope'     => 'email'));
			header("Location: ".$login_url);
		}
    }
    
    
    
    
    
    public function actiontwitter()
	{
            Yii::import('application.vendors.*');
            require_once('twitteroauth/twitteroauth.php');            
            //session_start();  
             // The TwitterOAuth instance  
            $twitteroauth = new TwitterOAuth('cgly7D3TMLGDrtSFkh5H2Q', 'qToktmub2ptOa93hn012r0XuBP4uuhEvZZdUZEPqQ');  
            // Requesting authentication tokens, the parameter is the URL we will be redirected to  
            $request_token = $twitteroauth->getRequestToken('http://localhost/yii/invision/index.php/site/twitter_oauth'); 
            // Saving them into the session  
            setcookie("oauth_token",$request_token['oauth_token'], time()+3600*24);
            setcookie("oauth_token_secret",$request_token['oauth_token_secret'], time()+3600*24);
//            $_SESSION['oauth_token'] = $request_token['oauth_token'];
//             $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
         //  die("eddie");
            // If everything goes well..  
            if($twitteroauth->http_code==200){  
                // Let's generate the URL and redirect  
                $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']); 
               
                header('Location: '. $url); 
            } else { 
                // It's a bad idea to kill the script, but we've got to know when there's an error.  
                die('Something wrong happened.');  
            } 
            $this->render('twitter');
        }
        
        public function actiontwitter_oauth()
	{    
                $baseurl  = Yii::app()->request->baseUrl;
            Yii::import('application.vendors.*');
            require_once('twitteroauth/twitteroauth.php');
           // echo '<pre>';print_r($_COOKIE); die("ee"); 
            if(!empty($_GET['oauth_verifier']) && !empty($_COOKIE['oauth_token']) && !empty($_COOKIE['oauth_token_secret'])){ 
                //we got every thing we want
            // TwitterOAuth instance, with two new parameters we got in twitter_login.php
            $twitteroauth = new TwitterOAuth('cgly7D3TMLGDrtSFkh5H2Q', 'qToktmub2ptOa93hn012r0XuBP4uuhEvZZdUZEPqQ', $_COOKIE['oauth_token'], $_COOKIE['oauth_token_secret']);          
            // Let's request the access token
            $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);   
            // Save it in a session var
              $_SESSION['access_token'] = $access_token;                                
            // Let's get the user's info
                    $user_info = $twitteroauth->get('account/verify_credentials'); 
                    //echo '<pre>';  print_r($user_info);   die();
                      $str=$user_info->name;
                      $name=(explode(" ",$str));// echo '<pre>'; print_r($name);
                    $twitter_id=$user_info->id;     //  die("herer");          
                    $usertable = UserDetail::model()->findByAttributes(array(),'twitter_id =:value', array(':value'=>$twitter_id));
                  //  echo '<pre>';  print_r($usertable);  
                             if(empty($usertable))
                                {
                                     $password =md5($user_info->id) ;  
                                     $model = new UserDetail;
                                     $model->username           = $user_info->name;			            
			             $model->email              = $twitter_id;
                                     $model->password              = $password;
                                     //$model->roles              ="user";
                                     $model->twitter_id        = $twitter_id;    
                                     if(isset($user_info->location)) 
                                    {  
                                      $location=trim($user_info->location);
                                      $model->location        = $location; 
                                    }
                                      
                                     $model->save(false);                                                       
                              
                                       $email     = $twitter_id;
                                      $models  = new LoginForm;
                                      if(isset($user_info))
                                        {
                                                $models->email=$twitter_id;						
						$record=UserDetail::model()->findByAttributes(array('twitter_id'=>$twitter_id));
                                                $models->password=$record['password'];                                                						
						if($models->login())
						{ 
                                                    
                                                     Yii::app()->SESSION['Logout_twitter']="logoutt";
                                                    $this->redirect(array('site/dashboard'));
                                                 
                                                    // $this->redirect(array('site/welcomeuser'));
                                                 
                                                }
                                        }
                                        
                                }
                            else {  
                                      $email     = $twitter_id;
                                  if(isset($user_info->location)) 
                                    {  
                                      $model2=UserDetail::model()->findByAttributes(array('email'=>$email));
                                      $location=trim($user_info->location);
                                      $model2->location        = $location; 
                                      $model2->save(false);
                                    }
                                      $models=new LoginForm;
                                    
                                      if(isset($user_info))
                                        {
                                                $models->email=$twitter_id;						
						$record=UserDetail::model()->findByAttributes(array('twitter_id'=>$twitter_id));
                                               // echo '<pre>'; print_r($record); die("herer");
                                                $models->password=$record['password'];                                                						
						if($models->login())
						{  
                                                    
                                                    Yii::app()->SESSION['Logout_twitter']="logoutt";
                                                    $this->redirect(array('site/dashboard'));
                                                  
                                                  
                                                  // $this->redirect($baseurl);
                                                  //   $this->redirect(array('site/welcomeuser'));
                                                
                                                }
                                                else {echo "problm";}
                                        }
                         }
            } 
           if(isset($_GET['denied']))
            {
                  
                $website =Yii::app()->params['siteurl'];
                header('Location: '. $website);  
            }
            else {
              
                // Something's missing, go back to twitter
                $baseurl = Yii::app()->request->baseUrl;                
                header("Location: $baseurl");
                 } 
       
        }
    
        
        public function actionGoogle_login()
	{
            $baseurl  = Yii::app()->request->baseUrl;
            $website  =  "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://localhost/yii/invision/";
            $google_client_id           = '664015273073.apps.googleusercontent.com';
            $google_client_secret 	= 'aXDlmu9KGnxHNefqf9NJJekX';
            $google_redirect_url 	= 'http://localhost/yii/invision/index.php/site/google_login/oauth2callback';
            $google_developer_key 	= 'AIzaSyD_xbtQSj10NPHNWanw_2AZwANuqfn0wRI';
            //include google api files
            
           Yii::import('application.vendors.*');
		require_once 'googleplus/src/Google_Client.php';
		require_once 'googleplus/src/contrib/Google_Oauth2Service.php';
         //echo "hiccccc"; exit;   
            $gClient = new Google_Client();
            $gClient->setApplicationName('Login to invision');
            $gClient->setClientId($google_client_id);
            $gClient->setClientSecret($google_client_secret);
            $gClient->setRedirectUri($google_redirect_url);
            $gClient->setApprovalPrompt('auto');
            $gClient->setDeveloperKey($google_developer_key);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
           // echo "<pre>";print_r($gClient);die('here');
            //If user wish to log out, we just unset Session variable
            if (isset($_REQUEST['reset']))
            {
                 
                unset($_SESSION['token']);
                $gClient->revokeToken();
                //header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
                header('Location: '. $website); 
                return;
            }
            if (isset($_GET['code']))
            {
                
                    $gClient->authenticate($_GET['code']);
                    $_SESSION['token'] = $gClient->getAccessToken();                    
//                    echo $google_redirect_url;
//                    header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
//                    return;
            }
            if (isset($_SESSION['token']))
            {
                
                $gClient->setAccessToken($_SESSION['token']);
            }

        if($gClient->getAccessToken())
        {         
                  $user 	= $google_oauthV2->userinfo->get();
                  $user_id 	= $user['id'];
                  $user_name 	= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
                  $email 	= filter_var($user['email'], FILTER_SANITIZE_EMAIL); 
                  $_SESSION['token'] = $gClient->getAccessToken();
        }
        else
        {
            $authUrl = $gClient->createAuthUrl();
            header('location:'.$authUrl);
            die();
        }
           $my_information=$user;
           $usertable = UserDetail::model()->findByAttributes(array(), 'google_id =:value OR email =:value2', array(':value'=>$my_information['id'], ':value2' => $my_information['email']));
//      
                            if(empty($usertable))
                                {
                                     $password =md5($my_information['id']) ;  
                                     $model = new UserDetail;
                                     $model->username           = $my_information['name'];			            
			             $model->email              = trim($my_information['email']);
                                     $model->password              = $password;
                                     $model->facebook_id        = $my_information['id']; 
                                     //$model->roles              ="user";
                                     if(isset($my_information["location"])) 
                                    {  
                                      $location=trim($my_information["location"]["name"]);
                                      $model->location        = $location; 
                                    }
                                      
                                     $model->save(false);                                                       
                              
                                     $email     = trim($my_information['email']);
                                      $models  = new LoginForm;
                                      if(isset($my_information))
                                        {
                                                $models->email=trim($my_information['email']);						
						$record=UserDetail::model()->findByAttributes(array('email'=>$my_information['email']));
                                                $models->password=$record['password'];                                                						
						if($models->validate() && $models->login())
						{  
                                                     Yii::app()->SESSION['Logout_googleplus']="logout";
                                                     $this->redirect(array('site/dashboard'));
                                                     //$this->redirect($baseurl);
                                                     exit;
                                                    
                                                 
                                                }
                                        }
                                        
                                }
                            else {  
                                   $email     = trim($my_information['email']);
                                   
                                    if(isset($my_information["location"])) 
                                    {  
                                      $model2=UserDetail::model()->findByAttributes(array('email'=>$email));
                                      $location=trim($my_information["location"]["name"]);
                                      $model2->location        = $location; 
                                      $model2->save(false);
                                    }
                                      $models=new LoginForm;
                                    
                                      if(isset($my_information))
                                        {
                                                $models->email=trim($my_information['email']);						
						$record=UserDetail::model()->findByAttributes(array('email'=>$my_information['email']));
                                                $models->password=$record['password'];                                                						
						if($models->validate() && $models->login())
						{   
                                                    Yii::app()->SESSION['Logout_googleplus']="logout";
                                                 
                                                      $this->redirect(array('site/dashboard'));
                                                     exit;
                                                
                                                
                                                }
                                        }
                         }
                      
            
        }
        
    
    
}
