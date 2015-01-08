<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */

	public $pageDescription;
	public $pageTags;

	public function beforeRender($view)
    {
 
        if (!empty($this->pageDescription))
        {
            Yii::app()->clientScript->registerMetaTag($this->pageDescription, 'description');
        }

        if(!empty($this->pageTags))
        {
        	Yii::app()->clientScript->registerMetaTag($this->pageTags, 'keywords');
        }
 
        return true;
 
    }

	public $breadcrumbs=array();
         protected $_canonicalUrl;
//        public function beforeAction($action) {
//            Yii::app()->theme='yours-goal'; // XXXX it's the name of the theme: webroot/themes/XXXX
//            return parent::beforeAction($action);
//        }
        
        //CHECKS IF USER HAS RIGHTS AND IS LOGGED IN ###############################
        public function beforeAction($action)
        {
                Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
//                if (Yii::app()->user->isGuest && $this->id != "login" && $this->id != "home")
//                        $this->redirect(Yii::app()->createUrl('/user/login'));
        
                //optionally include code here if its an authenticated user
                return true;
        }
       

/**
 * Default canonical url generator, will remove all get params beside 'id' and generates an absolute url.
 * If the canonical url was already set in a child controller, it will be taken instead.
 */
public function getCanonicalUrl() {
    if ($this->_canonicalUrl === null) {
        $params = array();
        if (isset($_GET['id'])) {
            //just keep the id, because it identifies our model pages
            $params = array('id' => $_GET['id']);
        }
        $this->_canonicalUrl = Yii::app()->createAbsoluteUrl($this->route, $params);
    }
    return $this->_canonicalUrl;
}
        /*
         * USED FOR OAUTH2 FACEBOOK LOGIN
         */
        public function initFacebookLogin()
        {
                require_once "application.extensions\oauth\login_with_facebook.php";
        }  
        
         /*
         * USED FOR OAUTH2 GOOGLE LOGIN
         */
        public function initGoogleLogin()
        {
                require_once "application.extensions\oauth\login_with_google.php";
        } 
        
        /*
         * USED FOR OAUTH2 TWIITER LOGIN
         */
        public function initTwitterLogin()
        {
                require_once "application.extensions\oauth\login_with_twitter.php";
        } 
        
        /*
         * USED FOR OAUTH2 VK LOGIN
         */
        public function initVkLogin()
        {
                require_once "application.extensions\oauth\login_with_vk.php";
        } 
}