<?php 
Yii::app()->clientScript->registerCssFile(
		Yii::app()->getAssetManager()->publish(
			Yii::getPathOfAlias('YumAssets').'/css/yum.css'));

$module = Yii::app()->getModule('user');
$this->beginContent($module->baseLayout); ?>
<section>
<div class="section-wrapper clearfix">
<!--<div class="maintenance-block">-->
<?php 
if($this->action->id != 'update'):
?> 
    <div id="usermenu">
    <?php Yum::renderFlash(); ?>
    <?php 
    if(Yum::hasModule('message')) {
            Yii::import('application.modules.message.components.*');
            $this->widget('MessageWidget');
    }
    if(Yum::hasModule('profile') && Yum::module('profile')->enableProfileVisitLogging) {
            Yii::import('application.modules.profile.components.*');
            $this->widget('ProfileVisitWidget'); 
    }
    $this->renderMenu(); ?>
    </div>
<?php 
endif;
?>

<div id="usercontent">
<?php echo $content;  ?>
</div>
<!-- </div>-->
</div>
 </section>
<?php $this->endContent(); ?>
