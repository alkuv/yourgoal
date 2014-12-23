<?php
/* @var $this TestimonialController */
/* @var $model Testimonial */

$this->breadcrumbs=array(
	'Testimonials'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Testimonial', 'url'=>array('index')),
	array('label'=>'Create Testimonial', 'url'=>array('create')),
	array('label'=>'Update Testimonial', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Testimonial', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Testimonial', 'url'=>array('admin')),
);
?>

<h1>View Testimonial #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'designation',
		'description',
		'image',
		'status',
	),
)); ?>
