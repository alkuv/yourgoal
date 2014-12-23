<?php
	Yii::app()->clientscript
		// use it when you need it!
		/*
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap.css' )
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap-responsive.css' )
		->registerCoreScript( 'jquery' )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-transition.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-alert.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-dropdown.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-scrollspy.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tab.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tooltip.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-popover.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-button.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-collapse.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-carousel.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-typeahead.js', CClientScript::POS_END )
		*/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title>
<?php 
$ur =  Yii::app()->urlManager->parseUrl(Yii::app()->request);
$c = explode('/',$ur);
$connection = Yii::app()->db;
//print_r($c);die;
if($c[0] == 'goal' && $c[1]== 'view' && $c[2] != '')
{
$command = $connection->createCommand('select name,discription from goal where id ='.$c[3]);
$row = $command->queryRow();
}
if($c[0] == 'goal' && $c[1]=='view')
{
	echo $row['name'];
}
else
{
	echo CHtml::encode($this->pageTitle);
}
?></title>
<?php if( $c[0] == 'goal' && $c[1]=='view')
{
	$desc =  $row['discription'];
}
else
{
	$desc = CHtml::encode($this->pageTitle);
}
?>
<meta name="description" content="<?php echo strip_tags($desc);?>">
<meta name="viewport" content="width=device-width">
<meta name="language" content="en" />
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!-- Le styles -->

<!--[if gte IE 9]>
    <style type="text/css">
      .gradient {

         filter: none;

      }
    </style>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
<!-- Le fav and touch icons -->

<!-- blueprint CSS framework ADDED FOR VALIDATIONS STARTS-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
<![endif]-->

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js" />

<script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>
<!-- blueprint CSS framework ADDED FOR VALIDATIONS END-->

<!-- <link rel="canonical" href="<?php //echo $this->canonicalUrl?>">-->
</head>

<body>
	<div class="main-site_container">

            <?php  include'header.php'; ?>
			<!-- dynamic active  menu  system start  -->
			<?php 
$controllerId = Yii::app()->controller->id;
$actionId = strtolower($this->getAction()->getId()); //echo $actionId;
if($controllerId=="site" || $controllerId=="goal" || $controllerId=="avatar"){
    
   if($controllerId=="goal") {if($actionId!="template"){$actionId="textpage";}}
?>
                <section class="mainMenu-full <?php echo $controllerId; ?>">

                    <div class="mainMenu-box">

                        <div class="section-wrapper clearfix">

                            <ul class="mainMenu clear-ul">

                                <li><a href="<?php echo Yii::app()->createUrl("goal/all"); ?>" class="mainMenu-item <?php if($actionId=="textpage"){echo "active";} ?>"><?php echo Yum::t("ЦЕЛИ")?></a></li>

                                <li><a href="<?php echo Yii::app()->createUrl("goal/template"); ?>" class="mainMenu-item item2  <?php if($actionId=="template"){echo "active";} ?>"><?php echo Yum::t("ШАБЛОНЫ")?></a></li>

                                <li><a href="<?php echo Yii::app()->createUrl("avatar/avatar/people"); ?>" class="mainMenu-item item3  <?php if($actionId=="people"){echo "active";} ?>"><?php echo Yum::t("ПОЛЬЗОВАТЕЛИ")?></a></li>

                                <li><a href="<?php echo Yii::app()->createUrl("site/help"); ?>" class="mainMenu-item item4 <?php if($actionId=="help"){echo "active";} ?>"><?php echo Yum::t("СПРАВКА")?></a></li>

                            </ul>

                        </div>

                    </div>
<?php   if($controllerId=="site" || $controllerId=="avatar") { ?>
                    <div class="mainMenu-tabs-box">

                        <div class="section-wrapper clearfix">
						<div class="mainMenu-tabs mainMenu-tab3 active">
                            <?php if($actionId=="people") { ?>     
                                <div class="mainMenu-tabBtm-title" style="text-transform: capitalize;"><?php echo Yum::t("Участники проекта");?></div><?php } else { ?>
                                <div class="mainMenu-tabBtm-title" style="text-transform: capitalize;"><?php echo Yum::t($actionId);?></div>
                                <?php } ?>
                            </div>

                        </div>

                    </div>
                    <?php } $actionId = strtolower($this->getAction()->getId()); //echo $controllerId."-".$actionId; ?>
            <?php   if($controllerId=="goal" && ($actionId=="all" || $actionId=="finished" || $actionId=="interesting") || $actionId=="following") {  ?>
                      <div class="mainMenu-tabs-box">
                        <div class="section-wrapper clearfix">
                     <ul class="mainMenu-tabs mainMenu-tab1 clear-ul active" id="filters">
                                <li><a href="<?php echo Yii::app()->createUrl("goal/interesting"); ?>" class="mainMenu-tabs-item <?php if($actionId=="interesting") { echo 'active'; } ?>" data-filter-value=".interesting" ><?php echo Yum::t("Интересные"); ?></a></li>
                                <li><a href="<?php echo Yii::app()->createUrl("goal/all"); ?>" class="mainMenu-tabs-item item2 <?php if($actionId=="all") { echo 'active'; } ?>" data-filter-value="*" ><?php echo Yum::t("Всё подряд"); ?></a></li>
                                <li><a href="<?php echo Yii::app()->createUrl("goal/finished"); ?>" class="mainMenu-tabs-item item3 <?php if($actionId=="finished") { echo 'active'; } ?>" data-filter-value=".completed" ><?php echo Yum::t("Достигнутые"); ?></a></li>
								<?php if(isset (Yii::app()->user->id)) { ?>
                                <li><a href="<?php echo Yii::app()->createUrl("goal/following"); ?>" class="mainMenu-tabs-item item3 <?php if($actionId=="following") { echo 'active'; } ?>" data-filter-value=".completed" ><?php echo Yum::t("Отлеживаемые"); ?></a></li>
								<?php } ?>
                                <!--<li><a href="javascript:void(0)" class="mainMenu-tabs-item item3"  ><?php echo Yum::t("category"); ?></a>
                                <select onchange="categoies(this.value)" name="cat" style=" margin-top: 33px;"> <?php  $allcategories=Categories::model()->findAll();?>
                                    <?php if(isset ($_REQUEST['cat'])) {$current_cate=$_REQUEST['cat']; } ?>
                                    <option><?php echo Yum::t("Select category"); ?></option>
                                       <?php foreach($allcategories as $category) {?>
                                       <option value="<?php echo $category->id;?>" <?php if($current_cate==$category->id) {?>selected="selected"<?php }?>><?php echo $category->category;?></option>
                                       <?php } ?>
                                </select>
                                </li>-->
								<?php  $allcategories=Categories::model()->findAll();?>
								<?php if(isset ($_REQUEST['cat'])) {$current_cate=$_REQUEST['cat']; } ?>
								 
								<ul class="ulone mainMenu-tabs mainMenu-tab1 clear-ul active"> 
									<li>По категориям
                                      <ul>
				  <?php foreach($allcategories as $category) {?>
			    <li><a href="?cat=<?php echo $category->id; ?>"><?php echo $category->category;?></a></li>											
											<?php } ?>
										</ul>
									</li>
								</ul>
								
								 
								
                     </ul>
                        </div>
                      </div>
                    <?php } else if($actionId=="template"){ ?>
                     <div class="mainMenu-tabs-box">

                        <div class="section-wrapper clearfix">
						<div class="mainMenu-tabs mainMenu-tab3 active">
                            
                                
                                <div class="mainMenu-tabBtm-title" style="text-transform: capitalize;"><?php echo Yum::t($actionId);?></div>
                              
                            </div>

                        </div>

                    </div>
                        <?php } ?>
                </section>
		<?php } ?>	
			<!-- dynamic active  menu  system End  -->
              <?php if(isset($this->breadcrumbs)):?>
                            <?php
//                                $this->widget('zii.widgets.CBreadcrumbs', array(
//                                    'links'=>$this->breadcrumbs,
//                                    'homeLink'=>false,
//                                    'tagName'=>'ul',
//                                    'separator'=>'',
//                                    'activeLinkTemplate'=>'<li><a href="{url}">{label}</a> <span class="divider">/</span></li>',
//                                    'inactiveLinkTemplate'=>'<li><span>{label}</span></li>',
//                                    'htmlOptions'=>array ('class'=>'breadcrumb')
//                                )); 
                            ?>
                    <!-- breadcrumbs -->
              <?php endif?>

            <?php echo $content ?>


            <div class="siteFooter-ejector"></div>
            
        </div><!--END main-site_container-->
	
		<?php  include'footer.php'; ?>
    
</body>
</html>
