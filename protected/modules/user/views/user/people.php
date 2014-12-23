<?php 
/*
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'sortableAttributes' => array('username', 'createtime', 'status', 'lastvisit', 'avatar'),
	'itemView' => '_view',
)); 
*/
?>
<style>.pager{clear:both;}</style>
<section class="peopleList">
<div class="section-wrapper clearfix">
    <div class="people-container">
   

        <div class="people-search-side clearfix">
            <form action="" method="POST">
            <input type="text" class="inputDef watermark" name="search_username" value="<?php echo $search_username; ?>"placeholder="start typing the name,nickname or city" />
            </form>
                    <div class="peopleCnt">
                        <?php 
                       // $vendor_detail=YumUser::model()->findAll();
                    //    echo '<pre>'; print_r($vendor_detail); echo '</pre>';
                        $count = User::model()->countByAttributes(array());
                        $goal_count = Goal::model()->countByAttributes(array());
                        ?>
                            <span class="objectsCnt"><?php echo $count; ?></span> members <br>
                            <span class="Cnt"><?php echo $goal_count;?></span>created goals
                     </div>
        </div>
    <ul class="people-side clear-ul clearfix">
<?php 
/*
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->searchpeople(),
	//'sortableAttributes' => array('username', 'createtime', 'status', 'lastvisit', 'avatar'),
	'itemView' => '_poeple',
)); 
*/


$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_poeple', 
    'template' => '{summary} {sorter} {items} <div style="clear:both;"></div> {pager}',
    'sortableAttributes'=>array(
        'username',
        'lastvisit',
    ),
));

?>
</ul>
<!--
                        	<div class="people-pager-side clearfix">
                                    <a href="" class="pager-prev nonactive"></a>
                                    <a href="" class="pager-next"></a>
                                    <ul class="clear-ul clearfix pager">
                                    	<li><a href="" class="pager-item">1</a></li>
                                    	<li><a href="" class="pager-item">2</a></li>
                                    	<li><a href="" class="pager-item">3</a></li>
                                    	<li><a href="" class="pager-item">4</a></li>
                                    	<li><a href="" class="pager-item sel">5</a></li>
                                    	<li><a href="" class="pager-item">6</a></li>
                                    	<li><a href="" class="pager-item">7</a></li>
                                    	<li><a href="" class="pager-item">8</a></li>
                                    </ul>
                                </div>-->

                            </div>

                             

                            

                            

    

                        </div>

                </section><!--END-->