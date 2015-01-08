<?php
/* @var $this GoalController */
/* @var $model Goal */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'goal-form',
	 'htmlOptions'=> array('enctype'=>"multipart/form-data"),
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
        <td align="left" valign="top"><?php echo $form->labelEx($model,'discription'); ?></td>
        <td align="left" valign="top"><?php
    $this->widget('application.extensions.cleditor.ECLEditor', array(
					'model'=>$model,
					'attribute'=>'discription',
					'value'=>$model->discription,
					'options'=>array(
						'width'=>'400',
						'height'=>250,
						'useCSS'=>true,
					),
				));
		?></td>
      </tr>
        <tr>
        <td align="left" valign="top"><?php echo $form->labelEx($model,'image'); ?></td>
        <td align="left" valign="top">
           <?php  echo CHtml::activeFileField($model, 'file' ,array('id'=>'imageupload',)); ?>
        </td>
      </tr>
      <tr>
        <td align="left" valign="top"><?php echo $form->hiddenField($model,'image',array('size'=>60,'maxlength'=>555)); ?></td>
        <td align="left" valign="top">
           &nbsp;
        </td>
      </tr>
       <tr>
        <td width="30%" align="left" valign="top"><?php echo $form->labelEx($model,'status'); ?></td>
        <td width="40%" align="left" valign="top"><?php echo ZHtml::enumDropDownList( $model,'status' );  ?></td>
      </tr>
      <tr>
        <td width="30%" align="left" valign="top"><?php echo $form->labelEx($model,'visibility'); ?></td>
        <td width="40%" align="left" valign="top"><?php echo ZHtml::enumDropDownList( $model,'visibility' );  ?></td>
      </tr>
     <tr>
        <td width="30%" align="left" valign="top"><?php echo $form->labelEx($model,'interesting_status'); ?></td>
        <td width="40%" align="left" valign="top"><?php echo ZHtml::enumDropDownList( $model,'interesting_status' );  ?></td>
      </tr>
       <tr>
        <td width="30%" align="left" valign="top"><?php echo $form->labelEx($model,'comment_status'); ?></td>
        <td width="40%" align="left" valign="top"><?php echo ZHtml::enumDropDownList( $model,'comment_status' );  ?></td>
      </tr>
      <tr>
        <td width="30%" align="left" valign="top"><?php  echo $form->labelEx($model,'category_id'); ?></td>
        <td width="40%" align="left" valign="top"><select class="selectDef" name="Goal[category_id]">
                                   <?php                                        
                                  $categorys=Categories::model()->findAll();                                  
                                  foreach($categorys as $category) {  ?>
                                   <option value="<?php echo $category->id;?>"><?php echo $category->category;?></option>
                                       <?php   } ?>
		</select></td>
      </tr>
       <tr>
        <td width="30%" align="left" valign="top"><?php echo $form->labelEx($model,'tags'); ?></td>
        <td width="40%" align="left" valign="top"><?php echo  $form->textField($model,'tags');  ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top" class="buttons"><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?></td>
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
        </table>
	

	

<!--	<div class="row">
		<?php echo $form->labelEx($model,'termination'); ?>
		<?php echo $form->textField($model,'termination',array('size'=>60,'maxlength'=>555)); ?>
		<?php echo $form->error($model,'termination'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'action'); ?>
		<?php echo $form->textField($model,'action',array('size'=>60,'maxlength'=>555)); ?>
		<?php echo $form->error($model,'action'); ?>
	</div>-->


<!--	<div class="row">
		<?php //echo $form->labelEx($model,'stage'); ?>
		<?php //echo $form->textArea($model,'stage',array('rows'=>6, 'cols'=>50)); ?>
		<?php //echo $form->error($model,'stage'); ?>
	</div>-->

<!--	<div class="row">
		<?php //echo $form->labelEx($model,'stage_description'); ?>
		<?php //echo $form->textArea($model,'stage_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php //echo $form->error($model,'stage_description'); ?>
	</div>-->

        
<!--	<div class="row">
		<?php //echo $form->labelEx($model,'view'); ?>
		<?php //echo $form->textField($model,'view',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo $form->error($model,'view'); ?>
	</div>-->

	

	

	


<!--
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>-->

<?php $this->endWidget(); ?>

</div><!-- form -->
 <script type="text/javascript">
    $( document ).ready(function() {
      
    function showimages(files) {
        for (var i = 0, f; f = files[i]; i++) {
		//alert(f.name);
            
            $('#ytimageupload').val(f.name);              
$('#Goal_image').val(f.name);              			
            var reader = new FileReader();
            reader.onload = function (evt) {
              //  var img = '<img width="77" style="float:left; margin-right:10px;"height="52" src="' + evt.target.result + '"/>';
              // $('.addingPhoto').append(img);
                
            }
            reader.readAsDataURL(f);
        }
    }
    $('#imageupload').change(function (evt) { 
        showimages(evt.target.files);
    });
    });
</script>