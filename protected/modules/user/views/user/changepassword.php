<?php 
$this->pageTitle = Yum::t("change password");
//echo '<h2>'. Yum::t('change password') .'</h2>';

$this->breadcrumbs = array(
	Yum::t("Change password"));

if(isset($expired) && $expired)
	$this->renderPartial('password_expired');
?>
  <div class="content maintenance-page">
                <section class="maintenance-section quoteMod-section">
                        <div class="section-wrapper clearfix">
    						<div class="maintenance-block">
                            	<h1 class="maintenance-title regMod">Change password.</h1>
								<img src="<?php echo Yii::app()->baseUrl; ?>/images/quote-img.png" width="64" height="60" alt="REG-PAGE" class="reg-img" />
<div class="form">
<?php echo CHtml::beginForm(); ?>
	<?php echo Yum::requiredFieldNote(); ?>
	<?php echo CHtml::errorSummary($form); ?>

	<?php if(!Yii::app()->user->isGuest) {
		echo '<div class="row">';
		echo CHtml::activeLabelEx($form,'currentPassword'); 
		echo CHtml::activePasswordField($form,'currentPassword'); 
		echo '</div>';
	} ?>

<?php $this->renderPartial(
		'application.modules.user.views.user.passwordfields', array(
			'form'=>$form)); ?>

	<div class="row submit">
	<?php echo CHtml::submitButton(Yum::t("Save"),array('class'=>'inputDefBtn')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
 </div>
</div>
</section>
</div>