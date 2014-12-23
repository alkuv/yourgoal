<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>


<div class="loging_con" style="margin-top:130px;">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<div class="login_l">
    	<label for="user" class="lbl"><img src="<?php echo Yii::app()->baseUrl; ?>/images/backend/icon/user.png" alt="" width="16" height="19" align="absbottom" /> <?php echo $form->labelEx($model,'username'); ?>:</label>
        <?php echo $form->textField($model,'username', array('class' => 'fld')); ?>
		
        <div class="err_O">
        	<?php echo $form->error($model,'username', array("class" => "err")); ?>
        </div>
        
        </label>
		<?php echo $form->checkBox($model,'rememberMe', array('id' => 'rem', 'checked' => 'checked' )); ?>
        <label for="rem"> <?php echo $form->label($model,'rememberMe'); ?></label><br /> 
  		<a href="<?php echo Yii::app()->createUrl('site/forgot'); ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/backend/icon/forget.png" alt="" width="15" height="14" align="absmiddle" />  &nbsp;Forgot Password?</a>
  </div>
  <div class="login_r"> 
   	<label for="pass" class="lbl"><img src="<?php echo Yii::app()->baseUrl; ?>/images/backend/icon/pass.png" alt="" width="16" height="19" align="absbottom" /> <?php echo $form->labelEx($model,'password'); ?>:</label>
     
    <?php echo $form->passwordField($model,'password', array('class' => 'fld')); ?>
	
    <div class="err_O">
	        <?php echo $form->error($model,'password', array("class" => "err")); ?>
    </div>
    
    
    <?php echo CHtml::submitButton('Sign In', array("class" => "btn")); ?>
  </div>
  <div class="clear"></div>
<?php $this->endWidget(); ?>  
</div>