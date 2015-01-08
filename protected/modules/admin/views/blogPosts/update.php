<?php
/* @var $this BlogPostsController */
/* @var $model BlogPosts */

$this->breadcrumbs=array(
	'Blog Posts'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BlogPosts', 'url'=>array('index')),
	array('label'=>'Create BlogPosts', 'url'=>array('create')),
	array('label'=>'View BlogPosts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BlogPosts', 'url'=>array('admin')),
);
?>

<h1>Update BlogPosts <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>