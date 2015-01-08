<?php
/* @var $this BlogPostsController */
/* @var $model BlogPosts */
/* @var $form CActiveForm */
?>

<script>
	
	function getalias(){

			var str = $("#title").val();
			$.post( "/admin/blogposts/trans", { str: str }, function( data ) {
				$( "#alias").val( data.trans ); 
			}, "json");

	}

</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'blog-posts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title', array('id' => 'title')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('id' => 'alias')); ?><a href="#" onClick="getalias();return false;">Сгенерировать ссылку</a>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tag'); ?>
		<?php echo $form->textArea($model,'tag',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'tag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cat_id'); ?>
		<?php 
		echo $form->dropDownList( $model,'cat_id',
			  CHtml::listData(Categories::model()->findAll(), 
                'id', 'category')
              // array('empty' => '(Select a category', 'name' => 'BlogPosts[cat_id]')
              	
              ); ?>
		<?php echo $form->error($model,'cat_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php 
		echo $form->dropDownList( $model,'user_id',
			  CHtml::listData(User::model()->findAll(), 
                'id', 'username')
              ); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>
<?php
$this->widget('application.extensions.eckeditor.ECKEditor', array(
    'model' => $model,
    'attribute' => 'description',
));
?>
</div><!-- form -->