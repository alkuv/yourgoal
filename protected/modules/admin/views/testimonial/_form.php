<?php
/* @var $this TestimonialController */
/* @var $model Testimonial */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'testimonial-form',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <table width="80%" border="0" cellpadding="5" style="margin:auto">
            
       <tr>
        <td width="30%" align="left" valign="top"><?php echo $form->labelEx($model,'name'); ?></td>
        <td width="40%" align="left" valign="top"><?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo $form->error($model,'name'); ?></td>
      </tr>
      
       <tr>
        <td width="30%" align="left" valign="top"><?php echo $form->labelEx($model,'designation'); ?></td>
        <td width="40%" align="left" valign="top"><?php echo $form->textField($model,'designation',array('size'=>60,'maxlength'=>100)); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo $form->error($model,'designation'); ?></td>
      </tr>
       <tr>
        <td align="left" valign="top"><?php echo $form->labelEx($model,'description'); ?></td>
        <td align="left" valign="top"><?php
        $this->widget('application.extensions.cleditor.ECLEditor', array(
					'model'=>$model,
					'attribute'=>'description',
					'value'=>$model->description,
					'options'=>array(
						'width'=>'400',
						'height'=>250,
						'useCSS'=>true,
					),
				));
		?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo $form->error($model,'description'); ?></td>
      </tr>
     
      <tr>
        <td width="30%" align="left" valign="top"><?php echo $form->labelEx($model,'image'); ?></td>
        <td width="40%" align="left" valign="top">
            <input type="file" name="icon"/>
        <?php //echo $form->hiddenField($model,'image',array('size'=>60,'maxlength'=>100)); ?>
        </td>
	</tr>
      <tr>
        <td align="left" valign="top"><?php echo $form->labelEx($model,'status'); ?></td>
        <td align="left" valign="top"><?php echo ZHtml::enumDropDownList( $model,'status' ); ?></td>
      </tr>
        </table>
     

	

	

	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->