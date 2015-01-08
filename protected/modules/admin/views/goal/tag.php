
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tag-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$dataProvider,
	'columns'=>array(
		'id',
		'name',
		'frequency',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
