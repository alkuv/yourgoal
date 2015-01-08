	<section>
	<?php // $user_detail = User::model()->findByPk("$id"); ?>
	<style>
	.dashgoals{text-decoration: none; color:#111}
        .deleteGaol{display: none;}
	</style>
	<?php //echo  $baseurl = Yii::app()->request->baseUrl; //echo '<pre>'; print_r($model); echo '</pre>';?>
	<div class="section-wrapper clearfix">
	<?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
	echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	}
	?>
	<?php 
	$connection = Yii::app()->db;
	$sql="select * from profile where user_id=$model->id";
	$command = $connection->createCommand($sql);
	$row = $command->queryRow();
	//echo '<pre>';print_r($row); echo '</prE>';
      //  die("eddide");
	$facebook_id=$row['facebook_id'];
	$google_id=$row['google_id'];
	$twitter_id=$row['twitter_id']; 
        $vk_id=$row['vk_id']; 
	?> 
	<div class="profile-container">
		<div class="people-search-side clearfix">
			<div class="img-box">
				<?php 
				//echo $model->avatar;
				if ($model->avatar!="" && $model->avatar!="gravatar") {?>
				<img src="<?php echo Yii::app()->baseUrl."/".$model->avatar;?>" width="256" height="256" alt="photo" />
				<?php } else { ?>
				<img src="<?php echo Yii::app()->baseUrl?>/images/noimage.png" width="256" height="256" alt="photo" />
				<?php } ?>
			</div>

			<div class="profile-info"> 
				<span class="profile-user">
					<?php if(!empty($facebook_id) || !empty($google_id) || !empty($twitter_id) || !empty ($vk_id)) { ?>
					<?php echo $row['firstname']; ?>
					<?php } else { ?>
					<?php echo $model->username; ?>
					<?php } ?>
				</span>
				<span class="profile-userInfo">
                                    <?php echo $row['about']?>
				</span> 
				<hr /> 
				<div class="userObjc">
					<span class="activeObjs">
					<?php echo  $cnt=Goal::model()->countByAttributes(array('author_id'=>Yii::app()->user->id,'status'=>"Active"));  ?>
					</span> active targets
					<span class="dot">.</span>
					<span class="completeObjs"><?php echo  $cnt=Goal::model()->countByAttributes(array('author_id'=>Yii::app()->user->id,'status'=>"Finished"));  ?></span> completed goals
				</div> 
			</div>    
			<div class="profile-control clearfix">
				<a href="<?php echo Yii::app()->createAbsoluteUrl("/goal/create/step/1"); ?>" class="yellow-btn">Add Aim</a>
				<a href="" class="link massage-link" style="display:none;">Messages</a><br>
				<a href="<?php echo Yii::app()->createAbsoluteUrl("profile/profile/update");?>" class="link profile-link">Profile</a>
				<!--<a href="<?php echo Yii::app()->createAbsoluteUrl("profile/profile/update");?> " style="margin-left: 45px;" class="link profile-link">Read News</a>-->
				<ul class="readNews"> 
					<li>
						Read News
						<ul>
							<li><a href="all" target="_blank">All</a></li>
							<li><a href="interesting" target="_blank">Interesting</a></li>
							<li><a href="following" target="_blank">Followed</a></li>
							<li><a href="finished" target="_blank">Finished</a></li>
						</ul>
					</li>
				</ul>
			
			</div> 
		</div>
		<div id="mainDragContainer">
			<div class="objectsBox clearfix">
				<div class="activeObjects" id="activeGoal">
					<h3 class="objects-title">Active targets</h3>
                   <!-- <div class=" activeObjects-list clear-ul sortable-list"> --> 
					<ul class=" scrollbox1 activeObjects-list clear-ul sortable-list">
						<?php    $draftgoals=Goal::model()->findAllByAttributes(array('author_id'=>Yii::app()->user->id,'status'=>"Active"),array("order" => "id desc", "limit" => 15));  
						if(!empty ($draftgoals)) {
						foreach($draftgoals as $goals) {               
						?>
						<li class="activeObjects-item" id="<?php echo $goals->id;?>">
							<h4 class="item-objName">
								<input type="radio" onclick="complete(<?php echo $goals->id;?>)"name="complete" value=""/>
								<a class="dashgoals" href='<?php echo  Yii::app()->createAbsoluteUrl("/goal/view/id/$goals->id") ?>'><?php echo $goals->name;?></a>
								
							</h4>
							
							<div class="btmBox">
								<span class="views" title="view">
                                                             <?php   echo  $views = Ipaddress::model()->countByAttributes(array('goal_id'=>$goals->id)); ?>
                                                                <?php //echo $goals->view;?>
                                                                </span>
								<a href="javascript:void(0);" onclick="deleteGoal('<?php echo $goals->id; ?>');" class="deleteGaol" title="Delete Goal">&nbsp</a>
								<a href="" class="comments" title=""></a>

								<?php    if(isset (Yii::app()->user->id)) {

								$record=Subscrbe::model()->findByAttributes(array('goal_id'=>$goals->id,'author_id'=>Yii::app()->user->id,'type'=>'subscribe')); 
								if(empty ($record)){
								$class="subscibewithoutlogin";
								}
								else{
								$class="subscibe";
								}
								}?>
								<a href="" class="<?php echo $class;?>" title="subscribe"></a>
								<a href="<?php echo  Yii::app()->createAbsoluteUrl("/goal/edit/id/$goals->id") ?>" class="editGoal" title="Edit Goal">&nbsp</a>

							</div>
						</li>

						<?php } } else {?><li class="activeObjects-item">
						<h4 class="item-objName">No Active Goal</h4>
						</li>
						<?php } ?>  
					</ul> 
                                            <!--</div>-->
				</div>
				
				<div class="activeObjects" id="draftGoal">
					<h3 class="objects-title">DRAFT LIST</h3>
					<ul class="scrollbox2 activeObjects-list clear-ul sortable-list">
						<?php    $draftgoals=Goal::model()->findAllByAttributes(array('author_id'=>Yii::app()->user->id,'status'=>"Draft"),array("order" => "id desc", "limit" => 15));  
						if(!empty ($draftgoals)) {
						foreach($draftgoals as $goals) {               
						?>
						<li class="activeObjects-item" id="<?php echo $goals->id;?>">
							<h4 class="item-objName">
								<input type="radio" onclick="complete(<?php echo $goals->id;?>)"name="complete" value=""/>
								<a class="dashgoals" href='<?php echo  Yii::app()->createAbsoluteUrl("/goal/view/id/$goals->id") ?>'><?php echo $goals->name;?></a>
								<!--<a class="" href='<?php echo  Yii::app()->createAbsoluteUrl("/goal/edit/id/$goals->id") ?>'>edit</a>-->
							</h4>
							
							<div class="btmBox">
								<span class="views" title="view">
                                                                    <?php   echo  $views = Ipaddress::model()->countByAttributes(array('goal_id'=>$goals->id)); ?>
                                                                        <?php //echo $goals->view;?>
                                                                </span>
								<a href="javascript:void(0);" onclick="deleteGoal('<?php echo $goals->id; ?>');" class="deleteGaol" title="Delete Goal">&nbsp</a>
								<a href="" class="comments" title=""></a>

								<?php    if(isset (Yii::app()->user->id)) {

								$record=Subscrbe::model()->findByAttributes(array('goal_id'=>$goals->id,'author_id'=>Yii::app()->user->id,'type'=>'subscribe')); 
								if(empty ($record)){
								$class="subscibewithoutlogin";
								}
								else{
								$class="subscibe";
								}
								}?>
								<a href="" class="<?php echo $class;?>" title="subscribe"></a>
								<a href="<?php echo  Yii::app()->createAbsoluteUrl("/goal/edit/id/$goals->id") ?>" class="editGoal" title="Edit Goal">&nbsp</a>

							</div>
						</li>

						<?php } } else {?><li class="activeObjects-item">
						<h4 class="item-objName">No Active Goal</h4>
						</li>
						<?php } ?>  
					</ul> 
				</div>
				
				<div class="activeObjects" id="completeGoal">
					<h3 class="objects-title">COMPLETED GOALS</h3>
					<ul class="scrollbox3 activeObjects-list clear-ul sortable-list">
						<?php    $draftgoals=Goal::model()->findAllByAttributes(array('author_id'=>Yii::app()->user->id,'status'=>"Finished"),array("order" => "id desc", "limit" => 15));  
						if(!empty ($draftgoals)) {
						foreach($draftgoals as $goals) {               
						?>
						<li class="activeObjects-item" id="<?php echo $goals->id;?>">
							<h4 class="item-objName">
								<input type="radio" onclick="complete(<?php echo $goals->id;?>)"name="complete" value=""/>
								<a class="dashgoals" href='<?php echo  Yii::app()->createAbsoluteUrl("/goal/view/id/$goals->id") ?>'><?php echo $goals->name;?></a>
								<!--<a class="" href='<?php echo  Yii::app()->createAbsoluteUrl("/goal/edit/id/$goals->id") ?>'>edit</a>-->
							</h4>
							
							<div class="btmBox">
								<span class="views" title="view">
                                                                    <?php   echo  $views = Ipaddress::model()->countByAttributes(array('goal_id'=>$goals->id)); ?>
                                                                        <?php //echo $goals->view;?>
                                                                </span>
								<a href="javascript:void(0);" onclick="deleteGoal('<?php echo $goals->id; ?>');" class="deleteGaol" title="Delete Goal">&nbsp</a>
								<a href="" class="comments" title=""></a>

								<?php    if(isset (Yii::app()->user->id)) {

								$record=Subscrbe::model()->findByAttributes(array('goal_id'=>$goals->id,'author_id'=>Yii::app()->user->id,'type'=>'subscribe')); 
								if(empty ($record)){
								$class="subscibewithoutlogin";
								}
								else{
								$class="subscibe";
								}
								}?>
								<a href="" class="<?php echo $class;?>" title="subscribe"></a>
								<a href="<?php echo  Yii::app()->createAbsoluteUrl("/goal/edit/id/$goals->id") ?>" class="editGoal" title="Edit Goal">&nbsp</a>

							</div>
						</li>

						<?php } } else {?><li class="activeObjects-item">
						<h4 class="item-objName">No Active Goal</h4>
						</li>
						<?php } ?>  
					</ul> 
				</div>
				<div class="activeObjects" id="failedGoal">
					<h3 class="objects-title">FAILED GOALS</h3>
					<ul class="scrollbox4 activeObjects-list clear-ul sortable-list">
						<?php    $draftgoals=Goal::model()->findAllByAttributes(array('author_id'=>Yii::app()->user->id,'status'=>"Inactive"),array("order" => "id desc", "limit" => 15));  
						if(!empty ($draftgoals)) {
						foreach($draftgoals as $goals) {               
						?>
						<li class="activeObjects-item" id="<?php echo $goals->id;?>">
							<h4 class="item-objName">
								<input type="radio" onclick="complete(<?php echo $goals->id;?>)"name="complete" value=""/>
								<a class="dashgoals" href='<?php echo  Yii::app()->createAbsoluteUrl("/goal/view/id/$goals->id") ?>'><?php echo $goals->name;?></a>
								<!--<a class="" href='<?php echo  Yii::app()->createAbsoluteUrl("/goal/edit/id/$goals->id") ?>'>edit</a>-->
							</h4>
							
							<div class="btmBox">
								<span class="views" title="view">
                                                                    <?php   echo  $views = Ipaddress::model()->countByAttributes(array('goal_id'=>$goals->id)); ?>
                                                                        <?php //echo $goals->view;?>
                                                                </span>
								<a href="javascript:void(0);" onclick="deleteGoal('<?php echo $goals->id; ?>');" class="deleteGaol" title="Delete Goal">&nbsp</a>
								<a href="" class="comments" title=""></a>

								<?php    if(isset (Yii::app()->user->id)) {

								$record=Subscrbe::model()->findByAttributes(array('goal_id'=>$goals->id,'author_id'=>Yii::app()->user->id,'type'=>'subscribe')); 
								if(empty ($record)){
								$class="subscibewithoutlogin";
								}
								else{
								$class="subscibe";
								}
								}?>
								<a href="" class="<?php echo $class;?>" title="subscribe"></a>
								<a href="<?php echo  Yii::app()->createAbsoluteUrl("/goal/edit/id/$goals->id") ?>" class="editGoal" title="Edit Goal">&nbsp</a>

							</div>
						</li>

						<?php } } else {?><li class="activeObjects-item">
						<h4 class="item-objName">No Active Goal</h4>
						</li>
						<?php } ?>  
					</ul> 
				</div>

				<!--<div class="toDoList"> 
					<h3 class="objects-title">DRAFT LIST</h3>
					<div class="toDoListBox" > 
						<div class="toDoList-items-box"> 
							<div class="toDoList-items scroll-pane" id="draftGoal"> 
								<ul class="inProgress-list sortable-list" style="height:480px;">
									<?php 
									$draftgoals=Goal::model()->findAllByAttributes(array('author_id'=>Yii::app()->user->id,'status'=>"Draft"),array("order" => "id desc", "limit" => 15));  
									if(!empty ($draftgoals)) { foreach($draftgoals as $goals) { ?> 
									<li class="toDoList-item" id="<?php echo $goals->id;?>"> 
										<a class="dashgoals" href='<?php echo  Yii::app()->createAbsoluteUrl("/goal/view/id/$goals->id") ?>'><?php echo $goals->name;?></a>
									</li>     
									<?php } }
									else{ ?>
									<li class="toDoList-item">
									No Record Found.
									</li>
									<?php }
									?>  
								</ul>  
							</div> 
						</div> 
						<div class="btmGradient"></div> 
					</div> 
				</div>--> 
			</div>
			<!--<div class="people-pager-side clearfix completeObjBlock" id="completeGoal">
				<h3 class="objects-title">COMPLETED GOALS</h3>

				<ul class="clear-ul clearfix sortable-list">
					<?php    $completedgoals=Goal::model()->findAllByAttributes(array('author_id'=>Yii::app()->user->id,'status'=>"Finished"),array("order" => "id desc", "limit" => 10));  
					if(!empty ($completedgoals)) {

					foreach($completedgoals as $goals) {               
					?>
					<li class="completeBtm-item ok" id="<?php echo $goals->id;?>">
					<a class="dashgoals" href='<?php echo  Yii::app()->createAbsoluteUrl("/goal/view/id/$goals->id") ?>'><?php echo $goals->name;  ?></a>
					<a style="margin-left:10px"href="<?php echo  Yii::app()->createAbsoluteUrl("/goal/edit/id/$goals->id") ?>"  title="Edit Goal">
					<img src="http://lab.aronasoft.in/yourgoal/themes/yours-goal/img/edit.png"/>
					</a>
					</li>

					<?php } } else { ?>
					<li class="completeBtm-item ok"><a class="dashgoals" >No Record Found </a></li>
					<?php } ?>
				</ul>  
			</div> -->
		</div>
	</div> 
</div>

	</section><!--END mostPurpose-->
