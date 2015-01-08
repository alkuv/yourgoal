<?php
/* @var $this BlogController */
/* @var $dataProvider CActiveDataProvider */
?>
<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Смотреть все', 'url'=>'/admin/blogposts/index', 'active'=>true),
        array('label'=>'Новый пост', 'url'=>'/admin/blogposts/create'),
    ),
)); ?>
<h3>Посты</h3>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$dataProvider,
    // 'dataProvider'=>$model->search(),
    // 'filter'=>$model,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array('name'=>'id', 'header'=>'#'),
        array('name'=>'title', 'header'=>'Названия'),
        array('name'=>'cat.category', 'header'=>'Категория'),
        array('name'=>'user.username', 'header'=>'Автор'),
        array('name'=>'created', 'header'=>'Время'),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
            'template'=>'{view} {update} {delete}',
            'buttons'=>array
            (
            	'view' => array
                (
                    'label'=>'Просмотр',
                    'icon'=>'eye-open',
                    'url'=>'Yii::app()->createUrl("blog/".$data->url)',
                ),
                'delete' => array
                (
                    'label'=>'Удалить',
                    'icon'=>'trash',
                    'url'=>'Yii::app()->createUrl("/admin/blogposts/delete/", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>