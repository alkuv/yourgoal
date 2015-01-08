<?php
/* @var $this FaqController */
/* @var $model Faq */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ques')); ?>:</b>
	<?php echo CHtml::encode($data->ques); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ans')); ?>:</b>
	<?php echo CHtml::encode($data->ans); ?>
	<br />


</div>