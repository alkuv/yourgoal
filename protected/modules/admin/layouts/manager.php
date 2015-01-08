<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

<!--        <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/main.css" />-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <!-- // <script type="text/javascript" src="/js/main.js"></script> -->
        <?php Yii::app()->bootstrap->register(); ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

<div class="container showgrid" id="page">

<?php // var_dump(Yii::app()->controller->id);  ?>
<div class="span-5 colborder">
    <?php 
    $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'Ресурсы проекта'),
        array('label'=>'Админ страница', 'icon'=>'home', 'url'=>'/admin'),
        array('label'=>'Блог', 'icon'=>'bullhorn', 'url'=>'/admin/blogposts/')
    ),
));
?>
</div>

<div class="span-18 last">
    <?php echo $content; ?>
</div>
            <div class="clear"></div>
            <div style="margin-bottom: 20px;"></div>
<div id="footer" class="span-24 last" align="right">
                
Copyright &copy; <?php echo '2013 - '. date('Y'); ?> by <a href="//exside.com.ua" target="_blank">Exside Company.</a><br/>
                All Rights Reserved.<br/>
</div><!-- footer -->

        </div><!-- page -->

    </body>
</html>
