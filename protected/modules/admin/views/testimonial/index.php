<?php
/* @var $this TestimonialController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Testimonials',
);

$this->menu=array(
	array('label'=>'Create Testimonial', 'url'=>array('create')),
	array('label'=>'Manage Testimonial', 'url'=>array('admin')),
);
?>

<h1>Testimonials</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
