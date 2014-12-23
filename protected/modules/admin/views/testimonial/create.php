<?php
/* @var $this TestimonialController */
/* @var $model Testimonial */

$this->breadcrumbs=array(
	'Testimonials'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Testimonial', 'url'=>array('index')),
	array('label'=>'Manage Testimonial', 'url'=>array('admin')),
);
?>

<h1>Create Testimonial</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>