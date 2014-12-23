  <style>#imageupload{display:none;}</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js">
</script>

<script type="text/javascript">
    $( document ).ready(function() {
    console.log( "ready!" );
    
    function showimages(files) {
        for (var i = 0, f; f = files[i]; i++) {
            $('#filesSize').append(f.name + ' - ' + f.size + '<br />');
            $('#ytimageupload').val(f.name);                      
            var reader = new FileReader();
            reader.onload = function (evt) {
                
            
                var img = '<img width="50" height="50" src="' + evt.target.result + '"/>';
                $('#images').append(img);
                
            }
            reader.readAsDataURL(f);
        }
    }

    $('#imageupload').change(function (evt) { 
        showimages(evt.target.files);
    });
    });
</script>
  <div class="content maintenance-page" style="clear:both">
                <section class="maintenance-section quoteMod-section">
                        <div class="section-wrapper clearfix">
    						<div class="maintenance-block">
                                                    <h1 class="maintenance-title regMod">Change Avatar</h1>
                                
                            		<p class="reg-title"><?php if(Yii::app()->user->isAdmin())
	echo Yum::t('Set Avatar for user ' . $model->username);
else if($model->avatar) {
	echo '<h2>';
	echo Yum::t('Your Avatar image');
	echo '</h2>';
	echo $model->getAvatar();
}
else
	echo Yum::t('You do not have set an avatar image yet');

	echo '<br />'; ?></p>
								<img src="<?php echo Yii::app()->baseUrl; ?>/images/quote-img.png" width="64" height="60" alt="REG-PAGE" class="reg-img" />
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'avatar-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
    'htmlOptions'=> array('enctype'=>"multipart/form-data"),
	'enableAjaxValidation'=>false,
)); 
 echo $form->errorSummary($model); ?>
<div class="row">
            <a href="javascript:void(0)" onclick="$('#imageupload').click()" class="upload" >Upload Image</a>
	</div>
        
	<div class="row">
		<?php //echo $form->labelEx($model,'file'); ?>
		<?php echo CHtml::activeFileField($model, 'file' ,array('id'=>'imageupload',)); ?>
		<?php echo $form->error($model,'file'); ?>
	</div>
	 <div id="filesSize"></div>
        
        <div id="images"></div>
	<?php
	if(Yum::module('avatar')->enableGravatar) 
	echo CHtml::link(Yum::t('Use Gravatar'), array(
				'//avatar/avatar/enableGravatar', 'id' => $model->id));

	echo '&nbsp;';
	echo CHtml::link(Yum::t('Remove Avatar'), array(
				'//avatar/avatar/removeAvatar', 'id' => $model->id));
        echo '<br />'; 
	echo CHtml::submitButton(Yum::t('Upload avatar'),array('class'=>'inputDefBtn'));
	?>
	<?php $this->endWidget(); ?>

</div>
 </div>
</div>
</section>
</div>