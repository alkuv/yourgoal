<?php 
$this->title = Yum::t('Request friendship for user {username}', array(
			'{username}' => $invited->username));
$this->breadcrumbs = array(
		Yum::t('Friendship'),
		Yum::t('Invitation'), $invited->username);
?>
  <div class="content maintenance-page">
                <section class="maintenance-section quoteMod-section">
                        <div class="section-wrapper clearfix">
                    <div class="maintenance-block">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/quote-img.png" width="64" height="60" alt="REG-PAGE" class="reg-img" />
                         	
<?php
$friendship_status = $invited->isFriendOf(Yii::app()->user->id);
	if($friendship_status !== false)  {
		if($friendship_status == 1)
			echo Yum::t('Friendship request already sent');
		if($friendship_status == 2)
			echo Yum::t('You already are friends');
		if($friendship_status == 3)
			echo Yum::t('Friendship request has been rejected');

		return false;
	} else {
		if(isset($friendship))
			echo CHtml::errorSummary($friendship);

		echo CHtml::beginForm(array('friendship/invite'));
		echo CHtml::hiddenField('user_id', $invited->id); ?>
<!--<h1 class="maintenance-title regMod">-->
		<?php echo CHtml::label(Yum::t('Please enter a request Message up to 255 characters'), 'message'); ?>
<!--</h1>-->
 <?php 
		echo '<br />';
		echo CHtml::textArea('message', '', array('cols' =>60, 'rows' => 10));
		echo '<br />';
		echo CHtml::submitButton(Yum::t('Send invitation'),array('class'=>'inputDefBtn'));
		echo CHtml::endForm();
	}
?>

</div>
</div>
</section>
</div>