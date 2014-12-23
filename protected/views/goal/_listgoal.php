<?php
$cnt=Subscrbe::model()->countByAttributes(array('goal_id'=>$data->id, 'type'=>"love")); 
 if(isset (Yii::app()->user->id)) 
         {
         $record=Subscrbe::model()->findByAttributes(array('goal_id'=>$data->id,'author_id'=>Yii::app()->user->id,'type'=>'love')); 
          if(empty ($record)){
               $class="purpose-cnt_without";
           }
           else{
                $class="purpose-cnt";
           }
         } 
 else
 { $class="purpose-cnt_without";}

?>
<div class="mostPurpose-block interesting" data-category="interesting"> 
    
    <div style="cursor:pointer;"class="<?php echo $class; ?>" id="love_<?php echo $data->id;?>" onclick="love(<?php echo $data->id ?>)">
       <?php echo $cnt;?>
    </div>
    
    <a href="<?php echo  Yii::app()->createAbsoluteUrl("/goal/view/id/$data->id") ?>">
        <?php if(empty ($data->image)) {?>
        <img src="<?php echo  Yii::app()->baseUrl?>/images/nogoal.jpg" width="471" height="264" alt="<?php echo Yum::t($data->name) ?>" />
        <?php } else { ?>
        <img src="<?php echo Yii::app()->baseUrl."/".$data->image;?>" width="471" height="264" alt="<?php echo Yum::t($data->name) ?>"/>
        <?php } ?>
    </a>
    <div class="clearfix"></div>  
    <a href="<?php echo  Yii::app()->createAbsoluteUrl("/goal/view/id/$data->id") ?>" class="mostPurpose-title">        
       <?php         
       if(strlen($data->name) > 40 )
               {
           echo substr(Yum::t($data->name),0,40)."..." ;
               }
       else
           {
            echo Yum::t($data->name);
           }
          
       ?>
    </a> 
    <?php  
   // $user_detail= Yii::app()->db->createCommand('select firstname from profile where user_id="'.$data->author_id.'"')->queryAll();
    //echo '<pre>'; print_r($user_detail); echo '</pre>';
  //  die("asdasd");
    $user_detail = User::model()->findByPk("$data->author_id"); 
	$command = Yii::app()->db->createCommand('select firstname from profile where user_id="'.$data->author_id.'"');
	$row = $command->queryRow();
	//echo '<pre>'; print_r($row); 
   ?>
    <p class="mostPurpose-date-box"><span><a href="<?php echo  Yii::app()->createUrl("profile/profile/views/id/".$user_detail->id);?>"><?php //echo $user_detail->username;
	echo $row['firstname'];?></a></span>,<?php echo  date('F j, Y',$data->create_time) ?></p>
        <hr />
       
            <?php   
$more=0;  			
           $des=   strip_tags($data->discription);
              if(strlen($des) > 200 )
               {  $more=1;  ?>
					 <p class="mostPurpose-text"> <?php echo substr($des,0,200);?><span class="readMore"></span></p>
              <?php  }
           else
               { ?>
                <p class="mostPurpose-text"> <?php echo $des; ?></p>
           <?php     }
            
            ?>
			<?php if($more==1) {?>
		<a class="readmore" style="z-index:2147483647;"href="<?php echo  Yii::app()->createAbsoluteUrl("/goal/view/id/$data->id") ?>"></a><?php } ?>
        </p>
                   

<div class="btmBox">
        <span class="views"> 
        <?php   echo  $views = Ipaddress::model()->countByAttributes(array('goal_id'=>$data->id)); ?>
           <?php //echo $data->view; ?>
        </span>
        <span class="comments"><?php echo $data->commentCount;?> comments</span>
        
      <?php   
		$ids = Yii::app()->user->id;
		//echo $data->author_id;die;
		
		if(isset (Yii::app()->user->id)) {          
           $record=Subscrbe::model()->findByAttributes(array('goal_id'=>$data->id,'author_id'=>Yii::app()->user->id,'type'=>'subscribe')); 
           if(empty ($record)){
               $class="subscibewithoutlogin";
           }
           else{
                $class="subscibe";
           }
		   
		
      ?> 
         <div id="subcribe_<?php echo $data->id; ?>" onClick="subscribe(<?php echo $data->id ?>);" class="<?php echo $class; ?>">Subscribe</div>
				<?php } else { ?>
         <div id="subcribe_<?php echo $data->id; ?>"  onClick="subscribe(<?php echo $data->id ?>);" class="subscibewithoutlogin">Subscribe</div>
                                <?php } ?>
        
       

</div>
</div>
