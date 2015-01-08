<?php
/* @var $this BlogPostsController */
/* @var $model BlogPosts */

$this->breadcrumbs=array(
	'Blog Posts'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List BlogPosts', 'url'=>array('index')),
	array('label'=>'Create BlogPosts', 'url'=>array('create')),
	array('label'=>'Update BlogPosts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BlogPosts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BlogPosts', 'url'=>array('admin')),
);
?>

<h1>View BlogPosts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'description',
		'image',
		'cat_id',
		'user_id',
		'created',
	),
)); ?>
