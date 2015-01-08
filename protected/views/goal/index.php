<?php
/* @var $this GoalController */
/* @var $dataProvider CActiveDataProvider */

/* $this->breadcrumbs=array(
	'Goals',
);

$this->menu=array(
	array('label'=>'Create Goal', 'url'=>array('create')),
	array('label'=>'Manage Goal', 'url'=>array('admin')),
);
?>

<h1>Goals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>


<?php if(!empty($_GET['tag'])): ?>
<h1>Posts Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>"{items}\n{pager}",
)); ?>
