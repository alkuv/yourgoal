<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>


<div class="loging_con" style="margin-top:130px;">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'forgot-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 

?>
<?php echo Yii::app()->user->getFlash('success'); ?>
	<div class="login_l">
    	<label for="user" class="lbl"><img src="<?php echo Yii::app()->baseUrl; ?>/images/user.png" alt="" width="16" height="19" align="absbottom" /> <?php echo $form->labelEx($model,'username'); ?>:</label>
        <?php echo $form->textField($model,'username', array('class' => 'fld')); ?>
		
        <div class="err_O">
        	<?php echo Yii::app()->user->getFlash('invalid'); ?>
        	<?php echo $form->error($model,'username', array("class" => "err")); ?>
        </div>
  		<a href="<?php echo Yii::app()->createUrl('site/login'); ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/forget.png" alt="" width="15" height="14" align="absmiddle" />  &nbsp; Login here </a>
  </div>
  <div class="login_r"> 
   	<label for="pass" class="lbl_0">&nbsp;</label>
    <?php echo CHtml::submitButton('Forgot Password', array("class" => "btn")); ?>
  </div>
  <div class="clear"></div>
<?php $this->endWidget(); ?>  
</div>