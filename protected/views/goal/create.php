<?php
/* @var $this GoalController */
/* @var $model Goal */

$this->breadcrumbs=array(
	'Goals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Goal', 'url'=>array('index')),
	array('label'=>'Manage Goal', 'url'=>array('admin')),
);
?>

<h1>Create Goal</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>