<?php
/* @var $this FaqController */
/* @var $model Faq */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faq-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    
    <table width="80%" border="0" cellpadding="5" style="margin:auto">
      <tr>
        <td align="left" valign="top"><?php echo $form->labelEx($model,'ques'); ?></td>
        <td align="left" valign="top"><?php echo $form->textArea($model,'ques',array('rows'=>3, 'cols'=>50)); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo $form->error($model,'ques'); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top"><?php echo $form->labelEx($model,'ans'); ?></td>
        <td align="left" valign="top"><?php
        $this->widget('application.extensions.cleditor.ECLEditor', array(
					'model'=>$model,
					'attribute'=>'ans',
					'value'=>$model->ans,
					'options'=>array(
						'width'=>'425',
						'height'=>250,
						'useCSS'=>true,
					),
				));
		?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo $form->error($model,'ans'); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save'); ?></td>
      </tr>
    </table>

<?php $this->endWidget(); ?>

</div><!-- form -->