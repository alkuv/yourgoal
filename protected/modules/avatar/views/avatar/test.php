<?php 
/*
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'sortableAttributes' => array('username', 'createtime', 'status', 'lastvisit', 'avatar'),
	'itemView' => '_view',
)); 
*/
?>
<style>.pager{clear:both;}.people-side-item{height:316px;}</style>
<section class="peopleList">
<div class="section-wrapper clearfix">
    <div class="people-container">
   <?php 
   
   Yii::app()->clientScript->registerScript('search',
    "var ajaxUpdateTimeout;
    var ajaxRequest;
    $('input#string').keyup(function(){ 
       var length= $('#string').val().length;
      // alert(length);
     //  if(length>=3){
        ajaxRequest = $(this).serialize();
        clearTimeout(ajaxUpdateTimeout);
        ajaxUpdateTimeout = setTimeout(function () {
            $.fn.yiiListView.update(
// this is the id of the CListView
                'ajaxListView',
                {data: ajaxRequest}
            )
        },
// this is the delay
        300);
//		}
    });"
);
   ?>
	 <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
        <div class="people-search-side clearfix">
	
		
		
            <?php 
            
            echo CHtml::beginForm(CHtml::normalizeUrl(array('avatar/people')), 'get', array('id'=>'filter-form'))
    . CHtml::textField('string', (isset($_GET['string'])) ? $_GET['string'] : '', array('id'=>'string','class'=>'inputDef watermark','placeholder'=>'start typing the name,nickname or city'))
   // . CHtml::submitButton('Search', array('name'=>''))
    . CHtml::endForm();
            
            ?>
<!--            <form action="" method="POST">
            <input type="text" class="inputDef watermark" name="search_username" value="<?php echo $search_username; ?>"placeholder="start typing the name,nickname or city" />
            </form>-->
                    <div class="peopleCnt">
                        <?php 
                   
                        $count = User::model()->countByAttributes(array());
                        $goal_count = Goal::model()->countByAttributes(array());
                        ?>
                            <span class="objectsCnt"><?php echo $count; ?></span> members <br>
                            <span class="Cnt"><?php echo $goal_count;?></span>created goals
                     </div>
        </div>
    <ul class="people-side clear-ul clearfix">
<?php 

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_poeple', 
    'id'=>'ajaxListView',
    'template' => '{summary} {sorter} {items} <div style="clear:both;"></div> {pager}',
    'sortableAttributes'=>array(
        'username',
        'lastvisit',
    ),
));

?>
</ul>
            </div>
        </div>

                </section>