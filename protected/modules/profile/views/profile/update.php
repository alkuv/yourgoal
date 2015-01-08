<?php 
$this->pageTitle = Yum::t( "Profile");
$this->breadcrumbs=array(
		Yum::t('Edit profile'));
$this->title = Yum::t('Edit profile');
?>
<style>
#usercontent{width:100%}
.textareaDefa{height: 200px; width: 445px;}
    </style>
 <div class="content maintenance-page">
    <section class="maintenance-section">
        <div class="section-wrapper clearfix">
            <div class="maintenance-block rememberPass" >
                <h1 class="maintenance-title">Profile Settings</h1>
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/user-profile.png" width="48" height="42" alt="USER-PAGE" class="userFor-img" />
                <div class="form">
                    <?php echo CHtml::beginForm('','post', array('class'=>'login-form userForm', 'id'=>'userForm') ); ?>                    
                    <?php echo Yum::requiredFieldNote(); ?>
                    <?php echo CHtml::errorSummary(array($user, $profile)); ?>                    
                    
                    <?php echo CHtml::activeLabelEx($user,'username', array() ); ?>
                    <?php echo CHtml::activeTextField($profile,'firstname',array(
                                            'size'=>20,'maxlength'=>20, 'class'=>"inputDef") ); ?>
                    <?php echo CHtml::error($user,'username'); ?>
                    
                     <div class="clearfix"></div>
                    <hr class="hr1"/>
                    <?php //echo '<pre>'; print_r($profile); echo '</pre>'; ?>
                    
<!--                    <label>Name:</label><input type="text" class="inputDef"/>
                    <div class="clearfix"></div>
                    <hr/>-->
                    <?php echo CHtml::activeLabelEx($profile,'email', array() ); ?>
                    <?php echo CHtml::activeTextField($profile,'email',array(
                                            'size'=>20,'maxlength'=>20, 'class'=>"inputDef") ); ?>
                    <?php echo CHtml::error($profile,'email'); ?>
                    <div class="clearfix"></div>
                    <hr class="hr1"/>
                    <label>Password:</label><a href="<?php echo Yii::app()->createAbsoluteUrl("/user/user/changePassword"); ?>" class="blue-link changeAva">Change Password</a>
                    <div class="clearfix"></div>
                    <hr class="hr2"/>
                       <?php 
                   /*  echo CHtml::activeLabelEx($profile,'firstname', array() ); 
                     echo CHtml::activeTextField($profile,'firstname',array(
                                            'size'=>20,'maxlength'=>20, 'class'=>"inputDef") ); 
                     echo CHtml::error($profile,'firstname'); */?>
<!--                    <div class="clearfix"></div>
					 <hr class="hr2"/>-->
                       <?php // echo CHtml::activeLabelEx($profile,'lastname', array() ); ?>
<!--					   <label for="YumProfile_lastname">Surname</label>-->
                    <?php //echo CHtml::activeTextField($profile,'lastname',array(
                                           // 'size'=>20,'maxlength'=>20, 'class'=>"inputDef") ); ?>
                    <?php //echo CHtml::error($profile,'lastname'); ?>
<!--                    <div class="clearfix"></div>
                    <hr class="hr2"/>-->
                       <?php /*echo CHtml::activeLabelEx($profile,'nickname', array() ); 
					  
                     echo CHtml::activeTextField($profile,'nickname',array(
                                            'size'=>20,'maxlength'=>20, 'class'=>"inputDef") );
                     echo CHtml::error($profile,'nickname'); */?>
<!--                    <div class="clearfix"></div>
                    <hr class="hr1"/>-->
                    
                    <?php echo CHtml::activeLabelEx($profile,'city', array() ); ?>
                    <?php echo CHtml::activeTextField($profile,'city',array(
                                            'size'=>20,'maxlength'=>20, 'class'=>"inputDef") ); ?>
                    <?php echo CHtml::error($profile,'city'); ?>
                    <div class="clearfix"></div>
                    <hr class="hr1"/>
                    <label class="ava-lbl">Avatar:</label>

                    <div class="imgAva-box">
                        <div class="img-box">
                           <?php   echo $user->getAvatar(); ?>
<!--                            <img src="img/none-ava.png" width="66" height="66" alt="" />-->
                        </div>

                        <a href="<?php echo Yii::app()->createAbsoluteUrl("/avatar/avatar/editAvatar/".$user->id); ?>" class="blue-link changeAva">Edit avatar</a>

                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr4"/>
                    <label class="notice">Notification:</label>
                    <select class="selectDef">
                        <option>Once a week</option>
                        <option>Once a Day</option>
                        <option>Twice a week</option>
                    </select>
                    <div class="clearfix"></div>
                    <hr class="hr5"/>
                     <?php echo CHtml::activeLabelEx($profile,'about', array() ); ?>
                    <?php echo CHtml::activeTextArea($profile,'about',array(
                                            'rows'=>6, 'cols'=>50, 'class'=>"textareaDefa") ); ?>
                    <?php echo CHtml::error($profile,'about'); ?>
                    
                    
                    <div class="clearfix"></div>
                    <hr class="hr5"/>

                    <?php 
                       /* if(isset($profile) && is_object($profile)) 
                            $this->renderPartial('/profile/_form', array('profile' => $profile));
                    */?>
                    
                    <?php 
                    /*
                        if(Yum::module('profile')->enablePrivacySetting)
                                echo CHtml::button(Yum::t('Privacy settings'), array(
                                                        'submit' => array('/profile/privacy/update'))); 
                        
                            if(Yum::hasModule('avatar'))
                                    echo CHtml::button(Yum::t('Upload avatar Image'), array(
                                            'submit' => array('/avatar/avatar/editAvatar'))); 
                            echo CHtml::submitButton($user->isNewRecord 
                                    ? Yum::t('Create my profile') 
                                    : Yum::t('Save profile changes')); 
                  */  ?>

                    <input type="submit" class="inputDefBtn" value="Update details" />

                    <?php echo CHtml::endForm(); ?>

                </div><!-- form -->    

            </div>


        </div>

    </section>


</div><!--END content-->       
        
