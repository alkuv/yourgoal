<?php
$this->pageTitle=Yii::app()->name . ' - Change Password';
?>

<div class="bar">General Settings</div>
<br />

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>true,
)); ?>

<?php echo $form->errorSummary($model); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#333333" class="table">
    <tr>
      <td colspan="3"><?php
      foreach(Yii::app()->user->getFlashes() as $key => $message) {
	echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}
	  ?></th>
    </tr>
    <tr>
    	<th colspan="3">Fields with <span class="required">*</span> are required.</th>
    </tr>
    <tr class="light">
      <td><?php echo $form->labelEx($model,'password'); ?></td>
      <td><input type="password" name="oldpass" id="oldpass" value="" /></td>
      <td><?php echo $form->error($model,'password'); ?></td>
    </tr>
    <tr class="light">
      <td><?php echo $form->labelEx($model,'npassword'); ?></td>
      <td><input type="password" name="newpass" id="newpass" value="" /></td>
      <td><?php echo $form->error($model,'npassword'); ?></td>
    </tr>
    <tr class="light">
      <td><?php echo $form->labelEx($model,'ncpassword'); ?></td>
      <td><input type="password" name="newcpass" id="newcpass" value="" /></td>
      <td><?php echo $form->error($model,'ncpassword'); ?></td>
    </tr>
	<tr class="dark">
      <td colspan="3"><input type="submit" name="button" value="Update" class="btn" /></td>
    </tr>
	
</table>
<?php $this->endWidget(); ?>

</div><!-- form -->