<?php 
$this->pageTitle = Yum::t('Password recovery');

//$this->breadcrumbs=array(
//	Yum::t('Login') => Yum::module()->loginUrl,
//	Yum::t('Restore'));

?>

<div class="content maintenance-page">

    <section class="maintenance-section">

        <div class="section-wrapper clearfix">

            <div class="maintenance-block rememberPass">
                <?php 
                    if(Yum::hasFlash()) {
                        echo '<div class="success">';
                        echo Yum::getFlash(); 
                        echo '</div>';
                    }
                    else
                    {
                ?>
                        <h1 class="maintenance-title">Восстановление пароля</h1>

                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/login-icon.png" width="48" height="42" alt="LOGIN-PAGE" class="login-img" />
                        
                        <div class="form">
                            <?php echo CHtml::beginForm('','post', array('class'=>'login-form rememberMod-form', 'id'=>'rememberForm') ); ?>
                        
                                <?php echo CHtml::activeTextField($form,'login_or_email', array('class'=>'inputDef watermark', 'placeholder'=>'Электронная почта') ) ?>

                                <?php echo CHtml::error($form,'login_or_email'); ?>

                                <?php echo CHtml::submitButton(Yum::t('Выслать пароль'), array('class'=>'inputDefBtn', 'value'=>'Выслать пароль') ); ?>
                                
                                <?php #Авторизация
                                    if(Yum::hasModule('registration') && Yum::module('registration')->enableRegistration)
                                        echo CHtml::link(Yum::t("Регистрация"),
                                                        Yum::module('registration')->registrationUrl, array('class'=>"blue-link forgetPass") );
                                ?>
                                <a href="<?php echo Yii::app()->createAbsoluteUrl("/user/login"); ?>" class="blue-link">Вход</a>

                            <?php echo CHtml::endForm(); ?>
                        </div><!-- form -->
                <?php 
                    }
                ?>

            </div>

        </div>

    </section>


</div><!--END content-->

