<section class="mostPurpose">
     <?php 
     $actionId = strtolower($this->getAction()->getId());     
     Yii::app()->user->setState('targetUrl', Yii::app()->createUrl('goal/'.$actionId.'')); 
     ?>
 <div class="section-wrapper clearfix">
 <div class="mostPurpose-list grid" id="container">
<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_listgoal',
	'template'=>"{items}\n{pager}",
)); */ 

$this->widget('zii.widgets.CListView', array(
       'id' => 'VideoList',
       'dataProvider' => $dataProvider,
       'itemView' => '_listgoal',
       'template' => '{items} {pager}',
       'pager' => array(
                    'class' => 'ext.infiniteScroll.IasPager', 
                    'rowSelector'=>'.row', 
                    'listViewId' => 'VideoList', 
                    'header' => '',
                    'loaderText'=>'Loading...',
                    'options' => array('history' => false, 'triggerPageTreshold' => 2, 'trigger'=>'Load more'),
                  )
            )
       );
?>
 </div>
 </div>
</section>
