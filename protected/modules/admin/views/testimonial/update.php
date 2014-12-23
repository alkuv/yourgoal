<?php
/* @var $this TestimonialController */
/* @var $model Testimonial */

$this->breadcrumbs=array(
	'Testimonials'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Testimonial', 'url'=>array('index')),
	array('label'=>'Create Testimonial', 'url'=>array('create')),
	array('label'=>'View Testimonial', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Testimonial', 'url'=>array('admin')),
);
?>

<h1>Update Testimonial <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>