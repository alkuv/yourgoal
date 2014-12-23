<?php
$this->breadcrumbs=array(
	'Comments',
);
?>
<style>.comment{margin:10px 0; border: 1px solid #111; padding: 10px 0 10px 10px; box-shadow:0 2px 1px; border-radius:4px; -webkit-border-radius:4px; -moz-border-radius:4px}

</style>
<h1>Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
