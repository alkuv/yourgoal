<?php
/* @var $this BlogPostsController */
/* @var $model BlogPosts */

$this->breadcrumbs=array(
	'Blog Posts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BlogPosts', 'url'=>array('index')),
	array('label'=>'Manage BlogPosts', 'url'=>array('admin')),
);
?>

<h1>Create BlogPosts</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'tags' => $tags)); ?>