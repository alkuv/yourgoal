<section class="mostPurpose">
     <?php 
     $actionId = strtolower($this->getAction()->getId());     
     Yii::app()->user->setState('targetUrl', Yii::app()->createUrl('goal/'.$actionId.'')); 
     ?>
    <div class="section-wrapper clearfix">
        <?php
        foreach(Yii::app()->user->getFlashes() as $key => $message) {
                echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>
 <div class="mostPurpose-list grid" id="container">
<div id="posts" class="items">
    <?php if(!empty ($posts)) {?>
     <?php foreach($posts as $data): ?>
<?php $this->renderPartial('_listgoal', array('data'=>$data)); ?>
<?php endforeach; ?>
     <?php } else {?><h2><?php echo Yum::t("No record found"); ?></h2><?php } ?>
</div>
 </div>
    </div>
<?php $this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
    'contentSelector' => '#posts',
    'itemSelector' => 'div.mostPurpose-block',
    'loadingText' => 'Loading...',
    'donetext' => 'This is the end.',
    'pages' => $pages,
)); ?>
</section>ss