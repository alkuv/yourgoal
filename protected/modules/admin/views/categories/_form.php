<?php
/* @var $this CategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'categories-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <table width="80%" border="0" cellpadding="5" style="margin:auto">
      <tr>
        <td width="40%"><?php echo $form->labelEx($model,'category'); ?></td>
        <td width="60%"><?php echo $form->textField($model,'category',array('size'=>60,'maxlength'=>255)); ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><?php echo $form->error($model,'category'); ?></td>
      </tr>
      <!--<tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>-->
      <tr>
        <td>&nbsp;</td>
        <td><?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save'); ?></td>
        <td>&nbsp;</td>
      </tr>
    </table>

	<!--<div class="row">
		<?php //echo $form->labelEx($model,'pid'); ?>
		<?php //echo $form->textField($model,'pid'); ?>
		<?php //echo $form->error($model,'pid'); ?>
	</div>-->

<?php $this->endWidget(); ?>

</div><!-- form -->