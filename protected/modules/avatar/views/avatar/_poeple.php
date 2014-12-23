<?php

//echo '<pre>'; print_r($data); echo '</pre>';
$sql="select * from profile where user_id =".$data->id."";
    $information= Yii::app()->db->createCommand($sql)->queryRow();
	$facebook_id=$information['facebook_id'];
	$google_id=$information['google_id'];
	$twitter_id=$information['twitter_id'];
   //echo '<prE>'; print_r($information); echo '<pre>';
?>
<li class="people-side-item">
            <a href="<?php echo  Yii::app()->createUrl("profile/profile/views/id/".$data->id);?>" class="img-box">
			<?php if ($data->avatar!="" && $data->avatar!="gravatar") {?>
				<img src="<?php echo Yii::app()->baseUrl."/".$data->avatar;?>" width="150" height="150" alt="photo" />
				<?php } else { ?>
				<img src="<?php echo Yii::app()->baseUrl?>/images/noimage.png" width="150" height="150"alt="photo" />
				<?php } ?>
            <!--    <img src ="<?php echo Yii::app()->baseUrl; ?>/images/people/user1.png" width="150" height="150" alt="" />-->
             </a>
            <a href="<?php echo  Yii::app()->createUrl("profile/profile/views/id/".$data->id);?>" class="people-name">
                <span><?php 
                
                if(empty ($information['firstname']))
                {
			
                echo $data->username ;              
                }
                else
                    {
					
                    echo $information['firstname'];
                    } ?>
                <br/>
                <?php                 
                echo $information['lastname'];
                ?>
                </span>
            </a>			
	
            <p class="people-objects">
                <?php  echo $cnt=Goal::model()->countByAttributes(array('author_id'=>$data->id));  ?>
                     target
            </p>
            <p class="people-comment">
                  <?php  echo $cnt=Comment::model()->countByAttributes(array('email'=>$information['email'])); ?> comments
            </p>
             <hr />
             <?php if(Yii::app()->user->id) {?>
			 <?php  $subslist=Subscrbe::model()->findAllByAttributes(array('author_id'=>Yii::app()->user->id,'following_id'=>$data->id));  ?>
			 <?php if(!empty($subslist)) {?>
			  <a href="<?php echo Yii::app()->createAbsoluteUrl("/goal/unfollow/follow/".$data->id);?>" class="blue-link"> <?php echo Yum::t("Unfollow"); ?></a>
			 <?php } else {?>
			 <a href="<?php echo Yii::app()->createAbsoluteUrl("/goal/follow/follow/".$data->id);?>" class="blue-link"> <?php echo Yum::t("Follow"); ?></a>
            <?php } ?>
			<a href="<?php echo Yii::app()->createAbsoluteUrl("/friendship/friendship/invite/user_id/".$data->id);?>" class="blue-link" style="display:none">Add as friend</a>
             <?php } ?>

</li>