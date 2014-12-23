  <style>.errorSummary{color:red;} .errorSummary p{color:red;} .errorSummary ul {list-style:none}</style>
  <div class="content maintenance-page">
                <section class="maintenance-section quoteMod-section">
                        <div class="section-wrapper clearfix">
    						<div class="maintenance-block">
                            	<h1 class="maintenance-title regMod">Оставить отзыв</h1>
                                <p class="reg-title">Мы будем очень рады, если вы оставите отзыв о нашем сервисе.</p> 
								<img src="<?php echo Yii::app()->baseUrl; ?>/images/quote-img.png" width="64" height="60" alt="REG-PAGE" class="reg-img" />
								<?php
									foreach(Yii::app()->user->getFlashes() as $key => $message) {
										echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
									}
								?>
								<div class="form">
								<!--<form class="login-form quoteMod" id="quote-form">-->
								<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'feedback-form',
	 'htmlOptions'=>array(
                          'class'=>'login-form quoteMod',
                        ),

	'enableAjaxValidation'=>false,
	)); ?><?php echo $form->errorSummary($model); ?>
	
	<?php  if(isset (Yii::app()->user->id)) 
	{ 
		$id=Yii::app()->user->id;$connection = Yii::app()->db;
		$sql="select * from profile where user_id =$id";
		//$sql="select profile.email, user.username from profile Inner Join user on user.id =$id";
		$command = $connection->createCommand($sql);
		$row = $command->queryRow();
		//echo '<pre>';print_r($row); echo '</pre>';
		$userdetail=User::model()->findByPk($id); 
		$username=$userdetail->username;
		$email=$row['email'];
		
		if(is_numeric($email)) {$email="";}
		if(is_numeric($username)) {$username="";}
		
		//$usermodel=User::
		?>
		<input type="text" class="inputDef watermark" <?php if(!empty($username)) {?>readonly="readonly"<?php } ?> name="Feedback[name]" value="<?php echo $username;?>"placeholder="Ваше имя" />
		<input type="text" class="inputDef watermark" <?php if(!empty($email)) {?>readonly="readonly"<?php } ?> name="Feedback[email]"value="<?php echo $email;?>" placeholder="Email" style="margin-right:0" />
		<?php 
	} 
	else 
	
	{ ?>
		<input type="text" class="inputDef watermark" name="Feedback[name]" value="<?php echo $model->name;?>"placeholder="Ваше имя" />
		<input type="text" class="inputDef watermark" name="Feedback[email]"value="<?php echo $model->email;?>" placeholder="Email" style="margin-right:0" />
	<?php } ?>
	
	<textarea class="textareaDef" name="Feedback[description]" placeholder="Отзыв"><?php echo $model->description;?></textarea>
	<input type="submit" class="inputDefBtn" name="yt0"value="Отправить отзыв" />
	</form>
	<?php $this->endWidget(); ?>
 </div>
 </div>
</div>
</section>
</div><!--END content-->
