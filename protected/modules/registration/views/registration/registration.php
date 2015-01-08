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
VK.UI.button('login_button');
</script>
<?php $this->breadcrumbs = array(Yum::t('Registration')); ?>

<div class="content maintenance-page">


    <section class="maintenance-section">

        <div class="section-wrapper clearfix">

            <div class="maintenance-block">

                <h1 class="maintenance-title regMod">Реги�?траци�?</h1>

                <p class="reg-title">Создайте �?вой аккаунт</p>



                <img src="<?php echo Yii::app()->baseUrl; ?>/images/reg.png" width="40" height="40" alt="REG-PAGE" class="reg-img" />

                <p>Зареги�?трировать�?�? через �?оциальную �?еть</p>

                <div class="socials clearfix">

                    <a href="javascript:void(0);" id="login_button" onclick="VK.Auth.login(authInfo);" class="social-btn"></a>

                    <a onclick="login('<?php echo Yii::app()->createUrl("user/auth/facebooklogin"); ?>'); return false;" href="#" class="social-btn fb"></a>

                    <a href="<?php echo Yii::app()->createUrl("user/auth/twitter") ?>" class="social-btn tw"></a>

                    <a href="<?php echo Yii::app()->createUrl("user/auth/Google_login") ?>" class="social-btn gg"></a>

                </div>

                <p>или</p>


                <div class="form login-form">
                    <?php
//                    $activeform = $this->beginWidget('CActiveForm', array(
//                        'id' => 'registration-form',
//                        'enableAjaxValidation' => true,
//                        'enableClientValidation' => true,
//                        'focus' => array($form, 'username'),
//                    ));
                    ?>
                    
                    <?php  $activeform = $this->beginWidget('CActiveForm', array(
			'id'=>'registration-form',
			'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
			'focus'=>array($profile,'email'),
			));
                    ?>
                    

                    <?php // echo Yum::requiredFieldNote(); ?>
                    <?php echo CHtml::errorSummary(array($form, $profile)); ?>

                     <div class="row"> <?php
                    //echo $activeform->labelEx($form, 'username');
                    echo $activeform->textField($form, 'username', array('class' => "inputDef watermark", 'placeholder' => "Username"));
                    ?> </div>

                    <div class="row"> 
                    <?php
//                        echo $activeform->labelEx($profile,'email');
                        echo $activeform->textField($profile, 'email', array('class' => "inputDef watermark", 'placeholder' => "Email"));
                    ?> 
                    </div>  

                         <!--div class="row"> <?php
                  //  echo $activeform->labelEx($profile, 'firstname');
                    echo $activeform->textField($profile, 'firstname', array('class' => "inputDef watermark", 'placeholder' => "firstname"));
                    ?> </div>  
                    
                                            <div class="row"> <?php
                  //  echo $activeform->labelEx($profile, 'lastname');
                    echo $activeform->textField($profile, 'lastname', array('class' => "inputDef watermark", 'placeholder' => "lastname"));
                    ?> </div-->  

                    <div class="row">
                        <?php // echo $activeform->labelEx($form,'password'); ?>
                        <?php echo $activeform->passwordField($form, 'password', array('class' => "inputDef watermark", 'placeholder' => "Пароль")); ?>
                    </div>

                    <div class="row">
                        <?php // echo $activeform->labelEx($form,'verifyPassword'); ?>
                        <?php echo $activeform->passwordField($form, 'verifyPassword', array('class' => "inputDef watermark", 'placeholder' => "Пароль еще раз")); ?>
                    </div>

                    <div class="row submit">
                        <?php echo CHtml::submitButton(Yum::t('Registration'), array('class' => "inputDefBtn")); ?>
                    </div>

<?php $this->endWidget(); ?>

                    <div class="row">
                        <p class="hint">
                            <?php
                            if (Yum::hasModule('registration') && Yum::module('registration')->enableRegistration)
                                echo CHtml::link(Yum::t("Registration"), Yum::module('registration')->registrationUrl, array('class' => "blue-link forgetPass"));
//                                    if(Yum::hasModule('registration') 
//                                                    && Yum::module('registration')->enableRegistration
//                                                    && Yum::module('registration')->enableRecovery)
//                                    echo ' | ';
                            if (Yum::hasModule('registration') && Yum::module('registration')->enableRecovery)
                                echo CHtml::link(Yum::t("Lost password?"), Yum::module('registration')->recoveryUrl, array('class' => "blue-link"));
                            ?>
                        </p>
                    </div>

                </div><!-- form -->

            </div>

        </div>

    </section>


</div><!--END content-->