<?php 
if(!isset($model)) 
	$model = new YumUserLogin();

$module = Yum::module();

$this->pageTitle = Yum::t('Login');
if(isset($this->title))
$this->title = Yum::t('Login');
$this->breadcrumbs=array(Yum::t('Login'));

Yum::renderFlash();
?>

<script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>
<script language="javascript">
VK.init({
  apiId: 4657192 
});
function authInfo(response) {

  if (response.session) {
    console.log( JSON.stringify(response) );
   // alert('user: '+response.session.mid);
    var userid=response.session.mid;
    var first_name=response.session.user.first_name;
    var last_name=response.session.user.last_name;
//	alert(response.session.user.first_name);
//	alert(response.session.user.last_name);
        window.location = '<?php echo Yii::app()->createAbsoluteUrl("/user/auth/vk"); ?>?userid='+userid+'&first_name='+first_name+'&last_name='+last_name+'';
	
  } else {
    //alert('not auth');
  }
}
VK.Auth.getLoginStatus(authInfo);
VK.UI.button('logins');
</script>

<div class="content maintenance-page">

    <section class="maintenance-section">

        <div class="section-wrapper clearfix">

            <div class="maintenance-block">

                <h1 class="maintenance-title">Авторизация</h1>

                <img src="<?php echo Yii::app()->baseUrl; ?>/images/login-icon.png" width="48" height="42" alt="LOGIN-PAGE" class="login-img" />

                <p>Войти через социальную сеть</p>

                <div class="socials clearfix">

                    <a href="javascript:void(0);" id="logins" onclick="VK.Auth.login(authInfo);" class="social-btn"></a>

                    <a onclick="login('<?php echo $baseurl ?>/yourgoal/index.php/user/auth/facebooklogin'); return false;" href="#" class="social-btn fb"></a>

                    <a href="<?php echo Yii::app()->createUrl("user/auth/twitter"); ?>" class="social-btn tw"></a>

                    <a href="<?php echo Yii::app()->createUrl("user/auth/Google_login"); ?>" class="social-btn gg"></a>

                </div>

                <p>или</p>

                    <div class="form">
                        <p>
                        <?php 
                        echo Yum::t('Please fill out the following form with your login credentials:'); ?>
                        </p>

                        <?php echo CHtml::beginForm(array('//user/auth/login'), 'post', array('class'=>"login-form", 'id'=>"loginForm") );  ?>

                        <?php 
                        if(isset($_GET['action']))
                                echo CHtml::hiddenField('returnUrl', urldecode($_GET['action']));
                        ?>

                        <?php echo CHtml::errorSummary($model); ?>

                                <div class="row">
                                    <?php 
//                                        if($module->loginType & UserModule::LOGIN_BY_USERNAME 
//                                                        || $module->loginType & UserModule::LOGIN_BY_LDAP)
//                                        echo CHtml::activeLabelEx($model,'username'); 
//                                        if($module->loginType & UserModule::LOGIN_BY_EMAIL)
//                                                printf ('<label for="YumUserLogin_username">%s <span class="required">*</span></label>', Yum::t('E-Mail address')); 
//                                        if($module->loginType & UserModule::LOGIN_BY_OPENID)
//                                                printf ('<label for="YumUserLogin_username">%s <span class="required">*</span></label>', Yum::t('OpenID username'));  
                                    ?>

                                    <?php echo CHtml::activeTextField($model,'username', array('class'=>'inputDef watermark', 'placeholder'=>"Электронная почта" ) ) ?>
                                </div>

                                <div class="row">
                                        <?php // echo CHtml::activeLabelEx($model,'password'); ?>
                                        <?php echo CHtml::activePasswordField($model,'password', array('class'=>'inputDef watermark', 'placeholder'=>"Пароль" ) );
//                                        if($module->loginType & UserModule::LOGIN_BY_OPENID)
//                                                echo '<br />'. Yum::t('When logging in with OpenID, password can be omitted');
                         ?>

                                </div>

                        <div class="row rememberMe" style="float: left">
                        <?php echo CHtml::activeCheckBox($model,'rememberMe', array('style' => 'display: inline;')); ?>
                        <?php echo CHtml::activeLabelEx($model,'rememberMe', array('style' => 'display: inline;')); ?>
                        </div>

                        <div class="row submit">
                        <?php echo CHtml::submitButton(Yum::t('Login'), array('class'=>'inputDefBtn') ); ?>
                        </div>
                        
                        
                        
                        <div class="row">
                            <p class="hint">
                                    <?php 
                                    if(Yum::hasModule('registration') && Yum::module('registration')->enableRegistration)
                                    echo CHtml::link(Yum::t("Registration"),
                                                    Yum::module('registration')->registrationUrl, array('class'=>"blue-link forgetPass") );
//                                    if(Yum::hasModule('registration') 
//                                                    && Yum::module('registration')->enableRegistration
//                                                    && Yum::module('registration')->enableRecovery)
//                                    echo ' | ';
                                    if(Yum::hasModule('registration') 
                                                    && Yum::module('registration')->enableRecovery) 
                                    echo CHtml::link(Yum::t("Lost password?"),
                                                    Yum::module('registration')->recoveryUrl, array('class'=>"blue-link") );
                                    ?>
                            </p>
                        </div>
                        
                        
                        <?php echo CHtml::endForm(); ?>
                    </div><!-- form -->
                        
                        
                </form>

            </div>

        </div>

    </section>


</div><!--END content-->



<?php 
$form = new CForm(array(
			'elements'=>array(
				'username'=>array(
					'type'=>'text',
					'maxlength'=>32,
					),
				'password'=>array(
					'type'=>'password',
					'maxlength'=>32,
					),
				'rememberMe'=>array(
					'type'=>'checkbox',
					)
				),

			'buttons'=>array(
				'login'=>array(
					'type'=>'submit',
					'label'=>'Login',
					),
				),
			), $model);
?>

