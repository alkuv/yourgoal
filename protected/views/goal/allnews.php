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
     <?php foreach($posts as $record)
     {         
         $goalarray[]=$record->goal_id;
     }
     $new=array_unique($goalarray);
?>
     <?php //echo '<pre>'; print_r($goalarray); print_r($new);echo '</pre>';?>
<div id="posts" class="items">
     <?php foreach($new as $goal_id): ?>
	 <?php  //$goal_id=$datas->goal_id; ?>
	 <?php  $data = Goal::model()->findByPk("$goal_id"); ?>
    <?php // echo '</pre>';print_r($data);?>
    <?php if(!empty ($data)) { ?>
<?php $this->renderPartial('_listgoal', array('data'=>$data)); ?><?php } ?>
<?php endforeach; ?>
</div>
 </div></div>
<?php /*$this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
    'contentSelector' => '#posts',
    'itemSelector' => 'div.mostPurpose-block',
    'loadingText' => 'Loading...',
    'donetext' => 'This is the end.',
    'pages' => $pages,
)); */?>
</section>