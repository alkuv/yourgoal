<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>true,
)); ?>

	
<?php 
if(empty($model->author)) {
?>
	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>
<?php } else {?>
<?php echo $form->hiddenField($model,'author',array('size'=>60,'maxlength'=>128)); ?>
<?php } ?>
<?php if(empty($model->email)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
<?php } else {?>
<?php echo $form->hiddenField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
<?php } ?>
<?php if(empty($model->url)) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>
<?php } else {?>
<?php echo $form->hiddenField($model,'url',array('size'=>60,'maxlength'=>128)); ?>
<?php } ?>
	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('class'=>"textareaDef")); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Send' : 'Save',array('class'=>'inputDefBtn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->