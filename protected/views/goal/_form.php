<style>#imageupload{display:none;}</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js">
</script>

<script type="text/javascript">
    $( document ).ready(function() {
    console.log( "ready!" );
    
    function showimages(files) {
        for (var i = 0, f; f = files[i]; i++) {
            $('#filesSize').append(f.name + ' - ' + f.size + '<br />');
            $('#ytimageupload').val(f.name);                      
            var reader = new FileReader();
            reader.onload = function (evt) {
                
            
                var img = '<img width="50" height="50" src="' + evt.target.result + '"/>';
                $('#images').append(img);
                
            }
            reader.readAsDataURL(f);
        }
    }

    $('#imageupload').change(function (evt) { 
        showimages(evt.target.files);
    });
    });
</script>
<?php
/* @var $this GoalController */
/* @var $model Goal */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'goal-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
    'htmlOptions'=> array('enctype'=>"multipart/form-data"),
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discription'); ?>
		<?php echo $form->textArea($model,'discription',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'discription'); ?>
	</div>

        <div class="row">
            <a href="javascript:void(0)" onclick="$('#imageupload').click()" class="upload" >Upload Image</a>
	</div>
        
	<div class="row">
		<?php //echo $form->labelEx($model,'file'); ?>
		<?php echo CHtml::activeFileField($model, 'file' ,array('id'=>'imageupload',)); ?>
		<?php echo $form->error($model,'file'); ?>
	</div>
        
        <div id="filesSize"></div>
        
        <div id="images"></div>

<!--	<div class="row">
		<?php /*echo $form->labelEx($model,'status'); ?>
		<?php //echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
                <?php echo $form->dropDownList($model,'status',Goal::items('status')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'view'); ?>
		<?php echo $form->textField($model,'view',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'view'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'interesting_status'); ?>
		<?php echo $form->textField($model,'interesting_status',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'interesting_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_status'); ?>
		<?php echo $form->textField($model,'comment_status',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'comment_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_time'); ?>
		<?php echo $form->textField($model,'update_time',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'update_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_id'); ?>
		<?php echo $form->textField($model,'author_id'); ?>
		<?php echo $form->error($model,'author_id'); */ ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');  ?>
	</div> 

<?php $this->endWidget(); ?>

</div><!-- form -->