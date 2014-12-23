<style>.btmBox p{clear:both} .diaryEtaps{clear:both;}</style>
<?php

//$resizeObj1 = new resize();                                      
//$ip_adress=$resizeObj1 -> get_client_ip();
//$ip_adress;
$record=Ipaddress::model()->findByAttributes(array('ip_address'=>$ip_adress,'goal_id'=>$model->id,'user_id'=>Yii::app()->user->id)); 
if(empty ($record))
    {
        $ipmodel=new Ipaddress;
        $ipmodel->user_id=Yii::app()->user->id;
        $ipmodel->goal_id=$model->id;
        $ipmodel->ip_address=$ip_adress;
        $ipmodel->save(false);
    }
//echo '<pre>';print_r($model); echo '</pre>';

//Yii::app()->user->setState("titl",$model->name);
//Yii::app()->user->setState("desc",$model->discription);
?>
<meta property="og:title" content='<?php echo Yum::t($model->name); ?>'>
<meta property="og:site_name" content="Yougoal">
<meta property="og:url" content="<?php echo 'http://yourgoal.ru/goal/view/id/'.$model->id?>">
<meta property="og:site_name" content="Yougoal">
<meta property="og:description" content='<?php echo strip_tags($model->discription);?>'>
<?php if(!empty($model->image)) {?>
<meta property="og:image" content="<?php echo Yii::app()->baseUrl."/".$model->image;?>">
<?php } ?>

<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@yougoal" />
<meta name="twitter:creator" content="@yourgoal" />
<meta name="twitter:title" content='<?php echo Yum::t($model->name); ?>' />
<meta name="twitter:description" content='<?php echo strip_tags($model->discription);?>' />
<?php if(!empty($model->image)) {?>
<meta name="twitter:image" content="<?php echo Yii::app()->baseUrl."/".$model->image;?>" />
<?php }?>
<meta name="twitter:url" content="<?php echo 'http://yourgoal.ru/goal/view/id/'.$model->id?>" />
<?php // echo '<pre>'; print_r($model); echo '</pre>';
$viewed=$model->view+1;
//echo '<pre>';print_r($_SERVER);echo '</pre>';
?>

<style>.dairy-top .socials a{background: none;}</style>
<?php  Goal::model()->updateByPk($model->id,array("view"=>$viewed)); ?>
<section class="dairyContainer">
<div class="section-wrapper clearfix">
      <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="people-container">
<div class="people-search-side clearfix">
<div class="dairy-top">
            <div class="leftSide">
            <span class="dairy-top-title">
			<?php echo Yum::t($model->name);?> 
	
            </span>
			
			<?php if($kk==0 && $model->author_id==Yii::app()->user->id): ?>
			<span id="edit"><a  style="float:left;"href="<?php echo  Yii::app()->createAbsoluteUrl("/goal/edit/id/$model->id") ?>" class="redactStage">
			  <img src="<?php  echo Yii::app()->baseUrl;?>/images/redact.png" width="13" height="14" alt=""/></a> </span>
              <?php endif;?> 
            <div class="btmBox">
            <span class="views">
                <?php    
                 $views = Ipaddress::model()->countByAttributes(array('goal_id'=>$model->id));
                ?>
            <?php echo $views; //if(!empty($model->view)) {echo $model->view+1;} else {echo "0";}?>
            </span>
        <?php if(isset (Yii::app()->user->id)) 
            {
            $record=Subscrbe::model()->findByAttributes(array('goal_id'=>$model->id,'author_id'=>Yii::app()->user->id,'type'=>'subscribe')); 
           if(empty ($record)){
               $class="subscibewithoutlogin";
           }
           else{
                $class="subscibe";
           }
            }
            else {$class="subscibewithoutlogin";}
			
			$cnt=Subscrbe::model()->countByAttributes(array('goal_id'=>$model->id, 'type'=>"love")); 
 if(isset (Yii::app()->user->id)) 
         {
         $record=Subscrbe::model()->findByAttributes(array('goal_id'=>$model->id,'author_id'=>Yii::app()->user->id,'type'=>'love')); 
          if(empty ($record)){
               $classforlove="purpose-cnt_without";
           }
           else{
                $classforlove="purpose-cnt";
           }
         } 
 else
 { $classforlove="purpose-cnt_without";}
			
			
			
            ?>
			 <span class="subscribe" style="float:left">
            <a style="float: none;margin-left: 18px;" href="javascript:void(0)" id="subcribe_<?php echo $model->id; ?>" onClick="subscribe(<?php echo $model->id ?>);" class="<?php echo $class;?>">subscribe</a>
           </span>
		  <span class="likes">
           
		   <div style="cursor:pointer;"class="<?php echo $classforlove; ?>" id="love_<?php echo $model->id;?>" onclick="love(<?php echo $model->id ?>)">   
            <?php echo $cnt;?>		   
			</div>
            </span>
	
			
			</div>
            <hr style="width:176px;" />
            <!--span class="socials-title">Tell a friend:</span>
            <div class="socials clearfix">
                <!-- SMARTADDON BEGIN >
<script type="text/javascript">
(function() {
var s=document.createElement('script');s.type='text/javascript';s.async = true;
s.src='http://s1.smartaddon.com/share_addon.js';
var j =document.getElementsByTagName('script')[0];j.parentNode.insertBefore(s,j);
})();
</script>

<a href="http://www.smartaddon.com/?share" title="Share Button" onclick="return sa_tellafriend(<?php echo Yii::app()->createAbsoluteUrl("/goal/view/id/".$model->id);?>)">
    <img alt="Share" src="http://lab.aronasoft.in/yourgoal/themes/yours-goal/img/socials24.png" border="0" />
</a>
<!-- SMARTADDON END -->
<!--            <a href="javascript:void(0)" class="social-btn"></a>
            <a href="javascript:void(0)" class="social-btn fb"></a>
            <a href="javascript:void(0)" class="social-btn tw"></a>
            <a href="javascript:void(0)" class="social-btn gg"></a>>
			
            </div-->
			
            <br>
		<?php echo implode(', ', $model->tagLinks); ?>
		 
		
		<br />
		<br />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/social-likes_classic.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
				<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/social-likes.min.js"></script>
			<div class="social-likes">
			<div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
			<div class="twitter" title="Поделиться ссылкой в Твиттере">Twitter</div>
			<div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div>
			<div class="plusone" title="Поделиться ссылкой в Гугл-плюсе">Google+</div>
		</div>
            </div>
			
			
		<div class="rightSide">
        <div class="img-box">
              <?php   $user_detail = User::model()->findByPk("$model->author_id");
              
              
              $imagepath= $user_detail->avatar;
              if($imagepath=="" || $imagepath=="gravatar") {?>            
        <img src="<?php  echo Yii::app()->baseUrl;?>/images/noimage.png" width="215" height="201" alt="" />
        <?php } else {?>
         <img src="<?php  echo Yii::app()->baseUrl."/".$imagepath;?>" width="215" height="201" alt="" />
            <?php } ?>
        </div>
        <div class="diary-UserInf profile-control">	
        <?php
		$user_detail = User::model()->findByPk("$data->author_id"); 
		$command = Yii::app()->db->createCommand('select firstname from profile where user_id="'.$model->author_id.'"');
		$row = $command->queryRow();?>
        <span class="dairy-userName"><?php echo $row['firstname'];?></span>
        <hr />
        <a href="" style="display:none" class="link massage-link">Messages</a><br>
		 <?php  $id = Yii::app()->user->id?>
		<?php
		if($id === $model->author_id) {?>
		  <a href="<?php echo Yii::app()->createAbsoluteUrl("goal/dashboard");?>" class="link profile-link">Profile</a>
		<?php } else {?>
        <a href="<?php echo Yii::app()->createAbsoluteUrl("/profile/profile/views/id/".$model->author_id);?>" class="link profile-link">Profile</a>
		<?php } ?>
        </div>
        </div>
<div class="clearfix"></div>
<div class="btmSide" style="display:none">
<div class="progressState-pos">
<span class="state-pos active">1</span>
<span class="state-pos pos2">2</span>
<span class="state-pos pos3">3</span>
<span class="state-pos pos4">4</span>
<span class="state-pos pos5">5</span>
<span class="state-pos pos6">6</span>
<span class="state-pos pos7">7</span>
</div>
<div class="item-progressLine">
<div class="progressState" data-state="148"></div>
</div>
</div>
</div>
</div>
    
<div class="diaryEtaps">
        <div class="diaryStages-list-head clearfix">
		<?php if(!empty($model->image)) {?>
        <img src="<?php echo Yii::app()->baseUrl."/".$model->image;?>" width="430" height="300" alt="" />
		<?php } else {?>
		<img src="<?php echo  Yii::app()->baseUrl?>/images/nogoal.jpg" width="430" height="300" alt="" />
		<?php } ?>
        <p>
        <?php echo $model->discription;?>
        </p>
        </div>
            <div class="diaryStages-list-box clearfix">
            <h2>Steps to achieve the goals</h2>
        <ol class="diaryStages-list">
            <?php  
            $ser_stage=unserialize($model->stage); 
            $ser_des=unserialize($model->stage_description);
            $counter=count($ser_stage);
            $kk=0;$point=1;
        // echo '<pre>'; print_r($ser_stage);  print_r($ser_des);echo '</pre>'; 
			$connection = Yii::app()->db;
			$command = $connection->createCommand('select * from steps_achieved');
			$row = $command->queryAll();
			 
            for($k=0;$k<$counter;$k++) {
                if(!empty ($ser_stage[$k])): 
            ?>
				
            <li class="btmBox">
			<?php // echo $k; ?>
			<?php if(isset (Yii::app()->user->id) && $model->author_id == Yii::app()->user->id) {?> 
				 
                <input type ="checkbox" <?php if($row[$k]['status']=="1"){ echo "checked='checked'";}?> class="checklist" onclick = "checkPointDone(<?php echo $point ?>);" id="checklist<?php echo $point ?>"name="steps" value="<?php echo $point; ?>" /><p class="title"><span style="float:left;"><?php echo $ser_stage[$k]; ?></span></p>
                  
				  <?php } else { ?>
				    <input type ="checkbox" <?php if($row[$k]['status']=="1"){ echo "checked='checked'";} ?> class="checklist" id="checklist" name="steps" value="<?php echo $point; ?>" disabled="disabled" /><p class="title"><span style="float:left;"><?php echo $ser_stage[$k]; ?></span></p>
					<?php }?>				   
                       <p><?php echo $ser_des[$k]; ?></p>
                       

              </li>
      <?php $kk++; $point++; endif; } ?>
            

        </ol>
		<script type="text/javascript">
	 
	 function checkPointDone(checkPointId)
	 {
		var ischecked;  
		if($("#checklist"+checkPointId).is(":checked")== true){
			ischecked = "1";
		}else{
			ischeecked = "0";
		} 
		$.ajax({
			type:'GET',
			url:"<?php echo Yii::app()->createAbsoluteUrl("/goal/checkPointDone"); ?>",
			data:{id:checkPointId, goalId:'<?php echo $model->id ?>',ischecked:ischecked},
			success: function(data){
				if(data)
				{
					alert("Data Stored Sucessfully"); 
				}else{
					alert("Data Not Stored");
				}
			}
		
		});
	 }
	 </script>