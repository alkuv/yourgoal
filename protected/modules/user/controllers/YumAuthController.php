<?php

class YumAuthController extends YumController {

    public $defaultAction = 'login';
    public $loginForm = null;

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('login','googletest' , 'facebooklogin','facebook', 'FacebookLoginOauth', 'RegisterFaceBookLogin','Google_login','twitter_oauth','twitter','vk'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('logout'),
                'users' => array('@'),
            ),
            array('deny', // deny all other users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Handles user login via OpenLDAP
     */
    public function loginByLdap() {
        if (!Yum::module()->loginType & UserModule::LOGIN_BY_LDAP)
            throw new Exception('login by ldap was called, but is not activated in application configuration');

        Yii::app()->user->logout();

        $identity = new YumUserIdentity($this->loginForm->username, $this->loginForm->password);
        $identity->authenticateLdap();

        switch ($identity->errorCode) {
            case YumUserIdentity::ERROR_NONE:
                $duration = 3600 * 24 * 30; //30 days

                Yii::app()->user->login($identity, $duration);

                return $identity->user;
                break;
            case YumUserIdentity::ERROR_STATUS_INACTIVE:
                $this->loginForm->addError('status', Yum::t('Your account is not activated.'));
                break;
            case YumUserIdentity::ERROR_REMOVED:
                $this->loginForm->addError('status', Yum::t('Your account has been deleted.'));
                break;
            case YumUserIdentity::ERROR_STATUS_BANNED:
                $this->loginForm->addError('status', Yum::t('Your account is blocked.'));
                break;
            case YumUserIdentity::ERROR_PASSWORD_INVALID:
                Yum::log(Yum::t('Failed login attempt for {username} via LDAP', array(
                            '{username}' => $this->loginForm->username)), 'error');

                if (!$this->loginForm->hasErrors())
                    $this->loginForm->addError("password", Yum::t('Username or Password is incorrect'));
                break;
        }

        return false;
    }
    public function actionFacebook(){
        $this->loginByFacebook();
    }
    public function loginByFacebook() {
        if (!Yum::module()->loginType & UserModule::LOGIN_BY_FACEBOOK)
            throw new Exception('actionFacebook was called, but is not activated in application configuration');

        Yii::app()->user->logout();
        Yii::import('application.modules.user.vendors.facebook.*');
        $facebook = new Facebook(Yum::module()->facebookConfig);
        $fb_uid = $facebook->getUser();
        if ($fb_uid) {
            $profile = YumProfile::model()->findByAttributes(array('facebook_id' => $fb_uid));
            $user = ($profile) ? YumUser::model()->findByPk($profile->user_id) : null;
            try {
                $fb_user = $facebook->api('/me');
                if (isset($fb_user['email']))
                    $profile = YumProfile::model()->findByAttributes(array('email' => $fb_user['email']));
                else
                    return false;
                if ($user === null && $profile === null) {
                    // New account
                    $user = new YumUser;
                    $user->username = 'fb_' . YumRegistrationForm::genRandomString(Yum::module()->usernameRequirements['maxLen'] - 3);
                    $user->password = YumEncrypt::encrypt(YumUserChangePassword::createRandomPassword());
                    $user->activationKey = YumEncrypt::encrypt(microtime() . $user->password, $user->salt);
                    $user->createtime = time();
                    $user->superuser = 0;
                    if ($user->save()) {
                        $profile = new YumProfile;
                        $profile->user_id = $user->id;
                        $profile->facebook_id = $fb_user['id'];
                        $profile->email = $fb_user['email'];
                        $profile->save(false);
                    }
                } else {
                    //No superuser account can log in using Facebook
                    $user = $profile->user;
                    if ($user->superuser) {
                        Yum::log('A superuser tried to login by facebook', 'error');
                        return false;
                    }
                    //Current account and FB account blending
                    $profile->facebook_id = $fb_uid;
                    $profile->save(false);
                    $user->username = 'fb_' . YumRegistrationForm::genRandomString(Yum::module()->usernameRequirements['maxLen'] - 3);

                    $user->superuser = 0;
                    $user->save();
                }

                $identity = new YumUserIdentity($fb_uid, $user->id);
                $identity->authenticateFacebook(true);

                switch ($identity->errorCode) {
                    case YumUserIdentity::ERROR_NONE:
                        $duration = 3600 * 24 * 30; //30 days
                        Yii::app()->user->login($identity, $duration);
                        Yum::log('User ' . $user->username . ' logged in via facebook');
                        return $user;
                        break;
                    case YumUserIdentity::ERROR_STATUS_INACTIVE:
                        $user->addError('status', Yum::t('Your account is not activated.'));
                        break;
                    case YumUserIdentity::ERROR_STATUS_BANNED:
                        $user->addError('status', Yum::t('Your account is blocked.'));
                        break;
                    case YumUserIdentity::ERROR_PASSWORD_INVALID:
                        Yum::log(Yum::t('Failed login attempt for {username} via facebook', array(
                                    '{username}' => $user->username)), 'error');
                        $user->addError('status', Yum::t('Password incorrect.'));
                        break;
                }
                return false;
            } catch (FacebookApiException $e) {
                /* FIXME: Workaround for avoiding the 'Error validating access token.'
                 * inmediatly after a user logs out. This is nasty. Any other
                 * approach to solve this issue is more than welcomed.
                 */

                Yum::log('Failed login attempt for ' . $user->username . ' via facebook', 'error');
                return false;
            }
        } else
            return false;
    }
    public function actionfacebooklogin()
      {             
		$baseurl  = Yii::app()->request->baseUrl;
                   // Yii::import('application.vendors.*');
                    Yii::import('application.modules.user.vendors.*');
                        require_once 'facebook/facebook.php';
                        $config = array(
                                'appId' => '1496929280588809',
                                'secret' => '23e4880bdca5e586994622c654565415',

                        );
                       

		
		# Let's see if we have an active session
		$facebook = new Facebook($config);
		$user_id = $facebook->getUser();
                
		//$access_token = $facebook->getAccessToken();
			

		
		if(!empty($user_id))
		{
			# Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
			try{
				$uid  = $facebook->getUser();
				$user = $facebook->api('/me/friends');
				$my_information = $facebook->api('/'.$uid); 
                              
                            
			
			} catch (Exception $e)
			{}
			//echo '<pre>';print_r($my_information); echo '</pre>';
			//die("dfdfdf");
			if(!empty($my_information))
			{
			
			   $email12    = $my_information['email'];
			   $password12 = $my_information['id'] ;            
			   $password = md5($my_information['id']) ; 
			   $picture = "";
		       $userdetail = YumUser::model()->find("username='$email12'");
			   if(empty($userdetail))
			   {
				 
				 $time     = time();
				 $model    = new YumUser;
				 $model->username      = $email12;	                       
				 $model->password      = $password;
				 $model->salt          = $password; 
				 $model->activationKey = $password; 
				 $model->createtime    = $time; 
				 $model->avatar = $picture;
				 $model->superuser = 0; 
			     $model->status = 1;
				 $model->save(false);
				 
				 $model = YumUser::model()->find("username='$email12'");
				 $profile = new YumProfile;             
				 $profile->user_id   = $model->id;
				 $profile->facebook_id = $my_information['id'];
				 $profile->email     = $my_information['email'];
				 $profile->firstname = $my_information['first_name'];
				 $profile->lastname     = $my_information['last_name'];
				 $profile->save(false);
							
			   }
           $_POST['YumUserLogin']['username'] = $email12;
           $_POST['YumUserLogin']['password'] = $password12;
           
           $this->loginForm = new YumUserLogin('login');
           $this->loginForm->attributes = $_POST['YumUserLogin'];
            $t = Yum::module()->loginType;
			
			if ($this->loginForm->validate()) {
                
                if ($t & UserModule::LOGIN_BY_USERNAME) {
                    $success = $this->loginByFbUser();
                    if ($success)
                        $login_type = 'Facebook';
                    }
                
            }
            else{
                $this->loginForm->addError('username', Yum::t('Login is not possible with the given credentials'));
                die;
            }
			   
			 $this->redirect("$baseurl/index.php/goal/dashboard");  
			} else
			{
				# For testing purposes, if there was an error, let's kill the script
				die("There was an error.");
			}
		}
		else
		{
			# There's no active session, let's generate one
			//$login_url = $facebook->getLoginUrl();  
                      $login_url = $facebook->getLoginUrl(array('scope'     => 'email'));
                        header("Location: ".$login_url);
		}
    }
    
    public function actionvk()
    {       
        if(isset ($_REQUEST['userid']) && !empty ($_REQUEST['userid']))
            {
              $baseurl  = Yii::app()->request->baseUrl;
               $email12    = $_REQUEST['userid'];
               $password12 = $_REQUEST['userid'] ;            
               $password = md5($_REQUEST['userid']) ;
               $firstname=$_REQUEST['first_name'] ;   
               $lastname=$_REQUEST['last_name'] ;   
               $picture = "";
				$userdetail = YumUser::model()->find("username='$email12'");
               if(empty($userdetail))
               {                   
                     $time     = time();
                     $model    = new YumUser;
                     $model->username      = $email12;	                       
                     $model->password      = $password;
                     $model->salt          = $password; 
                     $model->activationKey = $password; 
                     $model->createtime    = $time; 
                     $model->avatar = $picture;
                     $model->superuser = 0; 
                     $model->status = 1;
                     $model->save(false);
                     
                     $model = YumUser::model()->find("username='$email12'");
                     $profile = new YumProfile;             
                     $profile->user_id   = $model->id;
                     $profile->vk_id = $email12;
                     $profile->email     = $email12;
                     $profile->firstname = $firstname;
                     $profile->lastname     = $lastname;
                     $profile->save(false);
               }
               $_POST['YumUserLogin']['username'] = $email12;
               $_POST['YumUserLogin']['password'] = $password12;

               $this->loginForm = new YumUserLogin('login');
               $this->loginForm->attributes = $_POST['YumUserLogin'];
               $t = Yum::module()->loginType;

                // validate user input for the rest of login methods
                if ($this->loginForm->validate()) {

                    if ($t & UserModule::LOGIN_BY_USERNAME) {
                        $success = $this->loginByGoogleUser();
                        if ($success)
                            $login_type = 'Google';
                        }

                }
                else{
                    $this->loginForm->addError('username', Yum::t('Login is not possible with the given credentials'));
                    die;
                }
                 $this->redirect("$baseurl/index.php/goal/dashboard");            
            }
    }


    public function actiontwitter()
	{
          // Yii::import('application.vendors.*');
            Yii::import('application.modules.user.vendors.*');
            require_once('twitteroauth/twitteroauth.php');            
            //session_start();  
           
            //$twitteroauth = new TwitterOAuth('cgly7D3TMLGDrtSFkh5H2Q', 'qToktmub2ptOa93hn012r0XuBP4uuhEvZZdUZEPqQ'); 
                $twitteroauth = new TwitterOAuth('YJ1WSqDbv4N43RO764E1Dn8I4', 'wEUR9ckxtGwsxti2hK0iyXrxOMcygEj5Z5WZk8xEau7IDkk3ke');  			
            // Requesting authentication tokens, the parameter is the URL we will be redirected to  
            $request_token = $twitteroauth->getRequestToken('http://yourgoal.ru/index.php/user/auth/twitter_oauth'); 
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
            //Yii::import('application.vendors.*');
                Yii::import('application.modules.user.vendors.*');
            require_once('twitteroauth/twitteroauth.php');
           // echo '<pre>';print_r($_COOKIE); die("ee"); 
            if(!empty($_GET['oauth_verifier']) && !empty($_COOKIE['oauth_token']) && !empty($_COOKIE['oauth_token_secret'])){ 
                //we got every thing we want
            // TwitterOAuth instance, with two new parameters we got in twitter_login.php
            $twitteroauth = new TwitterOAuth('YJ1WSqDbv4N43RO764E1Dn8I4', 'wEUR9ckxtGwsxti2hK0iyXrxOMcygEj5Z5WZk8xEau7IDkk3ke', $_COOKIE['oauth_token'], $_COOKIE['oauth_token_secret']);          
            // Let's request the access token
            $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);   
            // Save it in a session var
              $_SESSION['access_token'] = $access_token;                                
            // Let's get the user's info
                    $user_info = $twitteroauth->get('account/verify_credentials'); 
                    //echo '<pre>';  print_r($user_info);   die();
                      $str=$user_info->name;
                      $name=(explode(" ",$str));
                      $twitter_id=$user_info->id;     
                    /* echo '<pre>';print_r($user_info); echo '</pre>';
                      die("eddie");	*/
					$email12    = $user_info->screen_name;
					$password12 = $user_info->id ;							   
				    $password = md5($user_info->id) ; 
					//$picture = $user_info->profile_image_url;
					$picture = "";
					$userdetail = YumUser::model()->find("username='$email12'");
					if(empty($userdetail))
				   {
					 
					 $time     = time();
					 $model    = new YumUser;
					 $model->username      = $email12;	                       
					 $model->password      = $password;
					 $model->salt          = $password; 
					 $model->activationKey = $password; 
					 $model->createtime    = $time; 
					 $model->avatar = $picture;
					 $model->superuser = 0; 
					 $model->status = 1;
					 $model->save(false);
					 
					 $model = YumUser::model()->find("username='$email12'");
					 $profile = new YumProfile;             
					 $profile->user_id   = $model->id;
					 $profile->twitter_id = $user_info->id;
					 $profile->email     = $user_info->screen_name;
					 $profile->firstname = $user_info->name;
					// $profile->lastname     = $my_information['family_name'];
					 $profile->save(false);
								
				   }
				   else 
				   {
				    $userdetail->avatar = $picture;
					$userdetail->save(false);
				   }
	   $_POST['YumUserLogin']['username'] = $email12;
           $_POST['YumUserLogin']['password'] = $password12;
           
           $this->loginForm = new YumUserLogin('login');
           $this->loginForm->attributes = $_POST['YumUserLogin'];
            $t = Yum::module()->loginType;

            // validate user input for the rest of login methods
            if ($this->loginForm->validate()) {
                
                if ($t & UserModule::LOGIN_BY_USERNAME) {
                    $success = $this->loginByGoogleUser();
                    if ($success)
                        $login_type = 'Google';
                    }
                
            }
            else{
                $this->loginForm->addError('username', Yum::t('Login is not possible with the given credentials'));
                die;
            }
        /*   if ($success instanceof YumUser) {
                //cookie with login type for later flow control in app
                if ($login_type) {
                    $cookie = new CHttpCookie('login_type', serialize($login_type));
                    $cookie->expire = time() + (3600 * 24 * 30);
                    Yii::app()->request->cookies['login_type'] = $cookie;
                }
                Yum::log(Yum::t(
                                'User {username} successfully logged in (Ip: {ip})', array(
                            '{ip}' => Yii::app()->request->getUserHostAddress(),
                            '{username}' => $success->username)));
                if (Yum::module()->afterLogin !== false)
                    call_user_func(Yum::module()->afterLogin);
              
                $this->redirectUser($success);
            } else {
            $this->loginForm->addError('username', Yum::t('Login is not possible with the given credentials'));}
					  */
					  $this->redirect("$baseurl/index.php/goal/dashboard");
					
                   
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
            $website  =  "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://yourgoal.ru/index.php";
         //   $google_client_id           = '499285139371-lopfp75r7vh1uenjf3r3fjpp24e84b4v.apps.googleusercontent.com';
            $google_client_id           = '499285139371-lopfp75r7vh1uenjf3r3fjpp24e84b4v@developer.gserviceaccount.com';
            $google_client_secret 	= 'vhbvKiWZnjubGacFpKJFJZfj';
            $google_redirect_url 	= 'http://yourgoal.ru/index.php/user/auth/google_login/oauth2callback';
           // $google_developer_key 	= 'AIzaSyD_xbtQSj10NPHNWanw_2AZwANuqfn0wRI';
            $google_developer_key 	= 'AIzaSyDaGurA1XtbYOtgqaRlbr_s8OtnR7GPqzw';
            //include google api files
            Yii::import('application.modules.user.vendors.*');
          // Yii::import('application.vendors.*');
		require_once 'googleplus/src/Google_Client.php';
		require_once 'googleplus/src/contrib/Google_Oauth2Service.php';
        
            $gClient = new Google_Client();
            $gClient->setApplicationName('yourgoal');
            $gClient->setClientId($google_client_id);
            $gClient->setClientSecret($google_client_secret);
            $gClient->setRedirectUri($google_redirect_url);
            $gClient->setApprovalPrompt('auto');
            $gClient->setDeveloperKey($google_developer_key);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
           // 
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
           //echo "<pre>";print_r($user);die('here');
           $email12    = $my_information['email'];
           $password12 = $my_information['id'] ; 
           
           $password = md5($my_information['id']) ; 
           $picture = "";
           
           $userdetail = YumUser::model()->find("username='$email12'");
           
          
           if(empty($userdetail))
           {
             
             $time     = time();
             $model    = new YumUser;
             $model->username      = $email12;	                       
             $model->password      = $password;
             $model->salt          = $password; 
             $model->activationKey = $password; 
             $model->createtime    = $time; 
             $model->avatar = $picture;
             $model->superuser = 0; 
	     $model->status = 1;
             $model->save(false);
             
             $model = YumUser::model()->find("username='$email12'");
             $profile = new YumProfile;             
             $profile->user_id   = $model->id;
             $profile->google_id = $my_information['id'];
             $profile->email     = $my_information['email'];
             $profile->firstname = $my_information['given_name'];
             $profile->lastname     = $my_information['family_name'];
             $profile->save(false);
                        
           }
           $_POST['YumUserLogin']['username'] = $email12;
           $_POST['YumUserLogin']['password'] = $password12;
           
           $this->loginForm = new YumUserLogin('login');
           $this->loginForm->attributes = $_POST['YumUserLogin'];
            $t = Yum::module()->loginType;

            // validate user input for the rest of login methods
            if ($this->loginForm->validate()) {
                
                if ($t & UserModule::LOGIN_BY_USERNAME) {
                    $success = $this->loginByGoogleUser();
                    if ($success)
                        $login_type = 'Google';
                    }
                
            }
            else{
                $this->loginForm->addError('username', Yum::t('Login is not possible with the given credentials'));
                die;
            }
           if ($success instanceof YumUser) {
                //cookie with login type for later flow control in app
                if ($login_type) {
                    $cookie = new CHttpCookie('login_type', serialize($login_type));
                    $cookie->expire = time() + (3600 * 24 * 30);
                    Yii::app()->request->cookies['login_type'] = $cookie;
                }
                Yum::log(Yum::t(
                                'User {username} successfully logged in (Ip: {ip})', array(
                            '{ip}' => Yii::app()->request->getUserHostAddress(),
                            '{username}' => $success->username)));
                if (Yum::module()->afterLogin !== false)
                    call_user_func(Yum::module()->afterLogin);
                $this->redirect("$baseurl/index.php/goal/dashboard");
               // $this->redirectUser($success);
            } else {
            $this->loginForm->addError('username', Yum::t('Login is not possible with the given credentials'));}
           
            
        }
     public   function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
         public function actiongoogletest()
        {
	//die("sdsdsd");
            $my_information=Array
                (
                    'id' => "10692682551163122798845",
                    'email' => "aaaabhirahul913@gmail.com",
                    'verified_email' => '1',
                    'name' => 'RAHUL SHARMA',
                    'given_name' => 'RAHUL',
                    'family_name' => 'SHARMA',
                    'link' => 'https://plus.google.com/106926825511631227988',
                    'picture' => 'https://lh4.googleusercontent.com/-YEZaDJkXrik/AAAAAAAAAAI/AAAAAAAAAFc/_iMdFqOsDEo/photo.jpg',
                    'gender' => 'male',
                    'locale' => 'en',
                );
             if ($my_information)
                 {
                    Yii::import('application.modules.profile.models.*');
                     Yii::import('application.modules.registration.models.*');
					Yii::import('application.modules.user.models.*');
					Yii::import('application.modules.user.components.*');
                    $profile = YumProfile::model()->findByAttributes(array('google_id' => $my_information['id']));
                    $user = ($profile) ? YumUser::model()->findByPk($profile->user_id) : null;
		    
		 //   echo '<pre>';print_r($user); echo "chck";
                    try {
                     //   echo "hrer";
			
                         if (isset($my_information['email']))
                        $profile = YumProfile::model()->findByAttributes(array('email' => $my_information['email']));
                         
                         echo '<pre>';print_r($profile); print_r($user); echo '</pre>';
			 
                 if ($user == null && $profile == null) { 
                     
                    $user = new YumUser;
					//echo '<pre>';print_r($user); echo '</pre>'; die;
                     $user->username = 'go_' . $my_information['given_name'];
                   // $user->password = YumEncrypt::encrypt(YumUserChangePassword::createRandomPassword());
                   // $user->activationKey = YumEncrypt::encrypt(microtime() . $user->password, $user->salt);
				     $user->password = self::generateRandomString(14);
                     $user->activationKey = self::generateRandomString(14);
                    $user->createtime = time();
                    $user->superuser = 0; 
					$user->status = 1; 
					
		   
                    if ($user->save()) {
                        $profile = new YumProfile;
                        $profile->user_id = $user->id;
                        $profile->google_id = $my_information['id'];
                        $profile->email = $my_information['email'];
                        $profile->save(false);
                    }
                } else {
                    //No superuser account can log in using Facebook
                    $user = $profile->user;
                    if ($user->superuser) {
                        Yum::log('A superuser tried to login by facebook', 'error');
                        return false;
                    }
                    //Current account and FB account blending
                    $profile->google_id = $my_information['id'];
                    $profile->save(false);
                    $user->username = 'go_' . $my_information['given_name'];
                    $user->superuser = 0;
                    $user->save();
                }
				 $this->loginByEmaile($my_information['email']);
				/*  $identity = new YumUserIdentity();
				  $identity->authenticateGoogle(true);*/
				
			}
                    catch (GoogleApiException $e) {
                /* FIXME: Workaround for avoiding the 'Error validating access token.'
                 * inmediatly after a user logs out. This is nasty. Any other
                 * approach to solve this issue is more than welcomed.
                 */

                Yum::log('Failed login attempt for ' . $user->username . ' via Google', 'error');
                return false;
            }
                 
                 }
             else{return false;}
           // echo '<pre>'; print_r($my_information); echo '</pre>';die("eddie");
            
            
        }




        public function loginByUsername() { 
        if (Yum::module()->caseSensitiveUsers) {
            $user = YumUser::model()->find('username = :username', array(
        ':username' => $this->loginForm->username));}
        else { 
            $user = YumUser::model()->find('upper(username) = :username', array(
        ':username' => strtoupper($this->loginForm->username)));}
        
        if ($user)
            return $this->authenticate($user);
        else {
            Yum::log(Yum::t(
                            'Non-existent user {username} tried to log in (Ip-Address: {ip})', array(
                        '{ip}' => Yii::app()->request->getUserHostAddress(),
                        '{username}' => $this->loginForm->username)), 'error');

            $this->loginForm->addError('password', Yum::t('Username or Password is incorrect'));
        }

        return false;
    }
    
     public function loginByGoogleUser() { 
        if (Yum::module()->caseSensitiveUsers) {
            $user = YumUser::model()->find('username = :username', array(
        ':username' => $this->loginForm->username));}
        else { 
            $user = YumUser::model()->find('upper(username) = :username', array(
        ':username' => strtoupper($this->loginForm->username)));}
        
        if ($user)
            return $this->authenticateGoogle($user);
        else {
            Yum::log(Yum::t(
                            'Non-existent user {username} tried to log in (Ip-Address: {ip})', array(
                        '{ip}' => Yii::app()->request->getUserHostAddress(),
                        '{username}' => $this->loginForm->username)), 'error');

            $this->loginForm->addError('password', Yum::t('Username or Password is incorrect'));
        }

        return false;
    }
    
     public function authenticateGoogle($user) {
        
        $identity = new YumUserIdentity($user->username, $this->loginForm->password);
        $identity->loginByGoogle();
        
        switch ($identity->errorCode) {
            case YumUserIdentity::ERROR_NONE:
                $duration = $this->loginForm->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                Yii::app()->user->login($identity, $duration);
                return $user;
                break;
            case YumUserIdentity::ERROR_EMAIL_INVALID:
                $this->loginForm->addError("password", Yum::t('Username or Password is incorrect'));
                break;
            case YumUserIdentity::ERROR_STATUS_INACTIVE:
                $this->loginForm->addError("status", Yum::t('This account is not activated.'));
                break;
            case YumUserIdentity::ERROR_STATUS_BANNED:
                $this->loginForm->addError("status", Yum::t('This account is blocked.'));
                break;
            case YumUserIdentity::ERROR_STATUS_REMOVED:
                $this->loginForm->addError('status', Yum::t('Your account has been deleted.'));
                break;
            case YumUserIdentity::ERROR_PASSWORD_INVALID:
                Yum::log(Yum::t(
                                'Password invalid for user {username} (Ip-Address: {ip})', array(
                            '{ip}' => Yii::app()->request->getUserHostAddress(),
                            '{username}' => $this->loginForm->username)), 'error');

                if (!$this->loginForm->hasErrors())
                    $this->loginForm->addError("password", Yum::t('Username or Password is incorrect'));
                break;
                return false;
        }
    }
/*facebook login function Start*/
    public function loginByFbUser() { 
        if (Yum::module()->caseSensitiveUsers) {
            $user = YumUser::model()->find('username = :username', array(
        ':username' => $this->loginForm->username));}
        else { 
            $user = YumUser::model()->find('upper(username) = :username', array(
        ':username' => strtoupper($this->loginForm->username)));}
       // echo '<pre>';print_r($user); echo '</pre>';
        if ($user)
            return $this->authenticateFacebooks($user);
        else {
            Yum::log(Yum::t(
                            'Non-existent user {username} tried to log in (Ip-Address: {ip})', array(
                        '{ip}' => Yii::app()->request->getUserHostAddress(),
                        '{username}' => $this->loginForm->username)), 'error');

            $this->loginForm->addError('password', Yum::t('Username or Password is incorrect'));
        }

        return false;
    }
	
	    public function authenticateFacebooks($user) {
        
        $identity = new YumUserIdentity($user->username, $this->loginForm->password);
        //echo '<pre>';print_r($identity); echo '<pre>';
        //die("edde");
        $identity->loginByFb();
        
        switch ($identity->errorCode) {
            case YumUserIdentity::ERROR_NONE:
                $duration = $this->loginForm->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                Yii::app()->user->login($identity, $duration);
                return $user;
                break;
            case YumUserIdentity::ERROR_EMAIL_INVALID:
                $this->loginForm->addError("password", Yum::t('Username or Password is incorrect'));
                break;
            case YumUserIdentity::ERROR_STATUS_INACTIVE:
                $this->loginForm->addError("status", Yum::t('This account is not activated.'));
                break;
            case YumUserIdentity::ERROR_STATUS_BANNED:
                $this->loginForm->addError("status", Yum::t('This account is blocked.'));
                break;
            case YumUserIdentity::ERROR_STATUS_REMOVED:
                $this->loginForm->addError('status', Yum::t('Your account has been deleted.'));
                break;
            case YumUserIdentity::ERROR_PASSWORD_INVALID:
                Yum::log(Yum::t(
                                'Password invalid for user {username} (Ip-Address: {ip})', array(
                            '{ip}' => Yii::app()->request->getUserHostAddress(),
                            '{username}' => $this->loginForm->username)), 'error');

                if (!$this->loginForm->hasErrors())
                    $this->loginForm->addError("password", Yum::t('Username or Password is incorrect'));
                break;
                return false;
        }
    }

/*facebook login function end*/
    public function authenticate($user) {
        
        $identity = new YumUserIdentity($user->username, $this->loginForm->password);
        $identity->authenticate();
        switch ($identity->errorCode) {
            case YumUserIdentity::ERROR_NONE:
                $duration = $this->loginForm->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                Yii::app()->user->login($identity, $duration);
                return $user;
                break;
            case YumUserIdentity::ERROR_EMAIL_INVALID:
                $this->loginForm->addError("password", Yum::t('Username or Password is incorrect'));
                break;
            case YumUserIdentity::ERROR_STATUS_INACTIVE:
                $this->loginForm->addError("status", Yum::t('This account is not activated.'));
                break;
            case YumUserIdentity::ERROR_STATUS_BANNED:
                $this->loginForm->addError("status", Yum::t('This account is blocked.'));
                break;
            case YumUserIdentity::ERROR_STATUS_REMOVED:
                $this->loginForm->addError('status', Yum::t('Your account has been deleted.'));
                break;
            case YumUserIdentity::ERROR_PASSWORD_INVALID:
                Yum::log(Yum::t(
                                'Password invalid for user {username} (Ip-Address: {ip})', array(
                            '{ip}' => Yii::app()->request->getUserHostAddress(),
                            '{username}' => $this->loginForm->username)), 'error');

                if (!$this->loginForm->hasErrors())
                    $this->loginForm->addError("password", Yum::t('Username or Password is incorrect'));
                break;
                return false;
        }
    }

    public function loginByEmail() {
        if (Yum::hasModule('profile')) {
            Yii::import('application.modules.profile.models.*');

            $profile = YumProfile::model()->find('email = :email', array(
                ':email' => $this->loginForm->username));

            if ($profile && $profile->user)
                return $this->authenticate($profile->user);
        } else
            throw new CException(Yum::t(
                    'The profile submodule must be enabled to allow login by Email'));
    }
	  public function loginByEmaile($email) {
        if (Yum::hasModule('profile')) {
            Yii::import('application.modules.profile.models.*');

            $profile = YumProfile::model()->find('email = :email', array(
                ':email' => email));

            if ($profile && $profile->user)
                return $this->authenticate($profile->user);
        } else
            throw new CException(Yum::t(
                    'The profile submodule must be enabled to allow login by Email'));
    }
    public function loginByOpenid() {
        if (!Yum::module()->loginType & UserModule::LOGIN_BY_OPENID)
            throw new Exception('login by Open Id was called, but is not activated in application configuration');

        Yii::app()->user->logout();
        Yii::import('application.modules.user.vendors.openid.*');
        $openid = new EOpenID;
        $openid->authenticate($this->loginForm->username);
        return Yii::app()->user->login($openid);
    }

    public function loginByTwitter() {
        return false;
    }
    
    /*
     * USED FOR OAUTH2 FACEBOOK LOGIN
     */
    public function actionFacebookLoginOauth()
    {
        require_once(Yii::app()->basePath . '/extensions/oauth/login_with_facebook.php');
        $fb_uid = $facebookUser->id;
        if ($fb_uid) {
            //MAKE AVAILABLE THE PROFILE MODEL
            Yii::import('application.modules.profile.models.YumProfile');
            Yii::import('application.modules.registration.models.YumRegistrationForm');
            
            $profile = YumProfile::model()->findByAttributes(array('facebook_id' => $fb_uid));
            $user = ($profile) ? YumUser::model()->findByPk($profile->user_id) : null;
            try {
                $fb_user = $facebookUser;
                if (isset($fb_user->email) )
                    $profile = YumProfile::model()->findByAttributes(array('email' => $fb_user->email));
                else
                    return false;
                if ($user === null && $profile === null) {
                    // New account
                    $user = new YumUser;
                    $user->username = 'fb_' . YumRegistrationForm::genRandomString(Yum::module()->usernameRequirements['maxLen'] - 3);
                    $user->password = YumEncrypt::encrypt(YumUserChangePassword::createRandomPassword());
                    $user->activationKey = YumEncrypt::encrypt(microtime() . $user->password, $user->salt);
                    $user->createtime = time();
                    $user->superuser = 0;
                    if ($user->save()) {
                        $profile = new YumProfile;
                        $profile->user_id = $user->id;
                        $profile->facebook_id = $fb_user->id;
                        $profile->email = $fb_user->email;
                        $profile->save(false);
                    }
                } else {
                    //No superuser account can log in using Facebook
                    $user = $profile->user;
                    if ($user->superuser) {
                        Yum::log('A superuser tried to login by facebook', 'error');
                        return false;
                    }
                    //Current account and FB account blending
                    $profile->facebook_id = $fb_uid;
                    $profile->save(false);
                    $user->username = 'fb_' . YumRegistrationForm::genRandomString(Yum::module()->usernameRequirements['maxLen'] - 3);

                    $user->superuser = 0;
                    $user->save();
                }

                $identity = new YumUserIdentity($fb_uid, $user->id);
                
                //USER IDENTITY CODE FOR FB LOGIN
		$profile = YumProfile::model()->findByAttributes(array('facebook_id'=>$fb_uid));
		$user = ($profile) ? YumUser::model()->findByPk($profile->user_id) : null;
		if ($user === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else if($user->status == YumUser::STATUS_INACTIVE)
			$this->errorCode = self::ERROR_STATUS_INACTIVE;
		else if($user->status == YumUser::STATUS_BANNED)
			$this->errorCode = self::ERROR_STATUS_BANNED;
		else
		{
			$identity->authenticateFacebookOauth($user->id, $fb_uid);
		}
                
                print_r($identity->errorCode);
                switch ($identity->errorCode) {
                    case YumUserIdentity::ERROR_NONE:
                        $duration = 3600 * 24 * 30; //30 days
                        Yii::app()->user->login($identity, $duration);
                        Yum::log('User ' . $user->username . ' logged in via facebook');                        
                        $this->redirectUser($user);
//                        return $user;
                        break;
                    case YumUserIdentity::ERROR_STATUS_INACTIVE:
                        $user->addError('status', Yum::t('Your account is not activated.'));
                        break;
                    case YumUserIdentity::ERROR_STATUS_BANNED:
                        $user->addError('status', Yum::t('Your account is blocked.'));
                        break;
                    case YumUserIdentity::ERROR_PASSWORD_INVALID:
                        Yum::log(Yum::t('Failed login attempt for {username} via facebook', array(
                                    '{username}' => $user->username)), 'error');
                        $user->addError('status', Yum::t('Password incorrect.'));
                        break;
                }
                return false;
            } catch (FacebookApiException $e) {
                /* FIXME: Workaround for avoiding the 'Error validating access token.'
                 * inmediatly after a user logs out. This is nasty. Any other
                 * approach to solve this issue is more than welcomed.
                 */

                Yum::log('Failed login attempt for ' . $user->username . ' via facebook', 'error');
                return false;
            }
        }
        else
        {
            return false;
        }
    }  
    
    
    public function actionLogin() {

        // If the user is already logged in send them to the return Url 
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yum::module()->returnUrl);

        $this->layout = Yum::module()->loginLayout;
        $this->loginForm = new YumUserLogin('login');

        /**
         * Login process starts here.
         * Facebook doesn't need form validation. Neither Twitter I think.
         * We will eventually get a bug here. If a user has already logged in
         * both FB a Twitter and both login systems are activated, if he decides
         * to use his Twitter account instead of his FB one the system will use
         * the FB account info for login. Not critical. I still can sleep after
         * knowing about this.
         */
        $success = false;
        $action = 'login';
        $login_type = null;
        if (isset($_POST['YumUserLogin'])) {
            $this->loginForm->attributes = $_POST['YumUserLogin'];
            $t = Yum::module()->loginType;

            // validate user input for the rest of login methods
            if ($this->loginForm->validate()) {
                if ($t & UserModule::LOGIN_BY_USERNAME) {
                    $success = $this->loginByUsername();
                    if ($success)
                        $login_type = 'username';
                }
                if ($t & UserModule::LOGIN_BY_EMAIL && !$success) {
                    $success = $this->loginByEmail();
                    if ($success)
                        $login_type = 'email';
                }
                if ($t & UserModule::LOGIN_BY_OPENID && !$success) {
                    $this->loginForm->setScenario('openid');
                    $success = $this->loginByOpenid();
                    if ($success)
                        $login_type = 'openid';
                }
                if ($t & UserModule::LOGIN_BY_LDAP && !$success) {
                    $success = $this->loginByLdap();
                    $action = 'ldap_login';
                    $login_type = 'ldap';
                }
            }
            if ($t & UserModule::LOGIN_BY_FACEBOOK && !$success) {
                $success = $this->loginByFacebook();
                if ($success)
                    $login_type = 'facebook';
            }
            if ($t & UserModule::LOGIN_BY_TWITTER && !$success) {
                $sucess = $this->loginByTwitter();
                if ($success)
                    $login_type = 'twitter';
            }

            if ($success instanceof YumUser) {
                //cookie with login type for later flow control in app
                if ($login_type) {
                    $cookie = new CHttpCookie('login_type', serialize($login_type));
                    $cookie->expire = time() + (3600 * 24 * 30);
                    Yii::app()->request->cookies['login_type'] = $cookie;
                }
                Yum::log(Yum::t(
                                'User {username} successfully logged in (Ip: {ip})', array(
                            '{ip}' => Yii::app()->request->getUserHostAddress(),
                            '{username}' => $success->username)));
                if (Yum::module()->afterLogin !== false)
                    call_user_func(Yum::module()->afterLogin);
                 $success=Yii::app()->createAbsoluteUrl("/goal/dashboard");
                $this->redirect($success);
              
               // $this->redirectUser($success);
            } else
                $this->loginForm->addError('username', Yum::t('Login is not possible with the given credentials'));
        }


        $this->render(Yum::module()->loginView, array(
            'model' => $this->loginForm));
    }

    public function redirectUser($user) {
        $user->lastvisit = time();
        $user->save(true, array('lastvisit'));
        
        Yii::app()->user->setState('first_login', true);
        if (isset($_POST) && isset($_POST['returnUrl']))
            $this->redirect(array($_POST['returnUrl']));

        if ($user->superuser && Yum::module()->returnAdminUrl)
            $this->redirect(Yum::module()->returnAdminUrl);

        if (isset(Yii::app()->user->returnUrl)) {
            #$this->redirect(Yii::app()->user->returnUrl);#############MODIFIED TO REDIRECT TO PROFILE VIEW BY SHIV ON LOGIN
              if(isset (Yii::app()->user->targetUrl)) {$this->redirect(Yii::app()->user->targetUrl);} else {
            $this->redirect(Yii::app()->createAbsoluteUrl("/profile/profile/view/id/".Yii::app()->user->id));
        } }
        if ($user->isPasswordExpired())
            $this->redirect(array('passwordexpired'));

        if (Yum::module()->returnUrl !== '')
            $this->redirect(Yum::module()->returnUrl);
        else
            $this->redirect(Yii::app()->user->returnUrl);
        $this->redirect(Yum::module()->firstVisitUrl);
    }

    public function actionLogout() {
        // If the user is already logged out send them to returnLogoutUrl
        if (Yii::app()->user->isGuest)
            $this->redirect(Yum::module()->returnLogoutUrl);

        //let's delete the login_type cookie
        $cookie = Yii::app()->request->cookies['login_type'];
        if ($cookie) {
            $cookie->expire = time() - (3600 * 72);
            Yii::app()->request->cookies['login_type'] = $cookie;
        }

        if ($user = YumUser::model()->findByPk(Yii::app()->user->id)) {
            $username = $user->username;
            $user->logout();
            
//            if (Yii::app()->user->name == 'facebook')
//            {
//                    Yii::app()->session->destroy();
//            }
            if (Yii::app()->user->name == 'facebook' && 0) {//EXCLUDED BY SHIV FOR FACEBOOK CUSTOM LOGIN
                if (!Yum::module()->loginType & UserModule::LOGIN_BY_FACEBOOK)
                    throw new Exception('actionLogout for Facebook was called, but is not activated in main.php');

                Yii::import('application.modules.user.vendors.facebook.*');
                require_once('Facebook.php');
                $facebook = new Facebook(Yum::module()->facebookConfig);
                $fb_cookie = 'fbs_' . Yum::module()->facebookConfig['appId'];
                $cookie = Yii::app()->request->cookies[$fb_cookie];
                if ($cookie) {
                    $cookie->expire = time() - 1 * (3600 * 72);
                    Yii::app()->request->cookies[$cookie->name] = $cookie;
                    $servername = '.' . Yii::app()->request->serverName;
                    setcookie("$fb_cookie", "", time() - 3600);
                    setcookie("$fb_cookie", "", time() - 3600, "/", "$servername", 1);
                }
                $session = $facebook->getSession();
                Yum::log('Facebook logout from user ' . $username);
                Yii::app()->user->logout();
                $this->redirect($facebook->getLogoutUrl(array('next' => $this->createAbsoluteUrl(Yum::module()->returnLogoutUrl), 'session_key' => $session['session_key'])));
            } else {
                Yum::log(Yum::t('User {username} logged off', array(
                            '{username}' => $username)));

                Yii::app()->user->logout();
            }
        }
        $this->redirect(Yum::module()->returnLogoutUrl);
    }

}
