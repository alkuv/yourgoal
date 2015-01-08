<?php 
$this->pageTitle = Yum::t( "Profile");
$this->breadcrumbs=array(
		Yum::t('Edit profile'));
$this->title = Yum::t('Edit profile');
?>
        
 <div class="content maintenance-page">

    <section class="maintenance-section">

        <div class="section-wrapper clearfix">

            <div class="maintenance-block rememberPass">

                <h1 class="maintenance-title">Настройки профиля</h1>

                <img src="<?php echo Yii::app()->baseUrl; ?>/images/user-profile.png" width="48" height="42" alt="USER-PAGE" class="userFor-img" />

                <div class="form">
                    <?php echo CHtml::beginForm('','post', array('class'=>'login-form userForm', 'id'=>'userForm') ); ?>
                    
                    <?php echo Yum::requiredFieldNote(); ?>

                    <?php echo CHtml::errorSummary(array($user, $profile)); ?>
                    
                    
                    <?php echo CHtml::activeLabelEx($user,'Имя:', array() ); ?>
                    <?php echo CHtml::activeTextField($user,'username',array(
                                            'size'=>20,'maxlength'=>20, 'class'=>"inputDef") ); ?>
                    <?php echo CHtml::error($user,'username'); ?>
                    
                    
                    
                    <label>Имя:</label><input type="text" class="inputDef"/>

                    <div class="clearfix"></div>

                    <hr/>

                    <label>E-mail:</label><input type="text" class="inputDef"/>

                    <div class="clearfix"></div>

                    <hr class="hr1"/>

                    <label>Пароль:</label><a href="" class="blue-link changeAva">Изменить пароль</a>

                    <div class="clearfix"></div>

                    <hr class="hr2"/>

                    <label>Город:</label><input type="text" class="inputDef"/>

                    <div class="clearfix"></div>

                    <hr class="hr3"/>

                    <label class="ava-lbl">Аватар:</label>

                    <div class="imgAva-box">

                        <div class="img-box">

                            <img src="img/none-ava.png" width="66" height="66" alt="" />

                        </div>

                        <a href="" class="blue-link changeAva">Изменить аватар</a>

                    </div>

                    <div class="clearfix"></div>

                    <hr class="hr4"/>

                    <label class="notice">Уведомления:</label>

                    <select class="selectDef">

                        <option>Один раз в неделю</option>

                        <option>Два раза в неделю</option>

                        <option>Три раза в неделю</option>

                        <option>Четыре раза в неделю</option>

                    </select>

                    <div class="clearfix"></div>

                    <hr class="hr5"/>

                    <?php 
                        if(isset($profile) && is_object($profile)) 
                            $this->renderPartial('/profile/_form', array('profile' => $profile));
                    ?>
                    
                    <?php 

                        if(Yum::module('profile')->enablePrivacySetting)
                                echo CHtml::button(Yum::t('Privacy settings'), array(
                                                        'submit' => array('/profile/privacy/update'))); ?>

                    <?php 
                            if(Yum::hasModule('avatar'))
                                    echo CHtml::button(Yum::t('Upload avatar Image'), array(
                                            'submit' => array('/avatar/avatar/editAvatar'))); ?>

                    <?php echo CHtml::submitButton($user->isNewRecord 
                                    ? Yum::t('Create my profile') 
                                    : Yum::t('Save profile changes')); 
                    ?>

                    <input type="button" class="inputDefBtn" value="Обновить данные" />

                    <?php echo CHtml::endForm(); ?>

                </div><!-- form -->    

            </div>


        </div>

    </section>


</div><!--END content-->       
        
