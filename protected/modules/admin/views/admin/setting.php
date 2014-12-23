<?php
$this->pageTitle=Yii::app()->name . ' - Site Settings';
?>

<div class="bar">Site Settings</div>
<br />

<div class="form">

<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); 

foreach(Yii::app()->user->getFlashes() as $key => $message) {
	echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#333333" class="table">
    <tr>
    	<th colspan="3">Fields with <span class="required">*</span> are required.</th>
    </tr>
    <tr class="light">
      <td>Site Title <span class="require">*</span></td>
      <td>
      <?php $title=Options::model()->findByAttributes(array("name" => "title")); ?>
      <input type="text" name="title" class="" value="<?php echo $title->value; ?>" /></td>
      <td></td>
    </tr>
    <tr class="light">
      <td>Site Description</td>
      <td>
      <?php $description=Options::model()->findByAttributes(array("name" => "description")); ?>
      <textarea name="description" style="width:400px; height:50px;"><?php echo $description->value; ?></textarea></td>
      <td></td>
    </tr>
    <tr class="light">
      <td>Keywords</td>
      <td>
      <?php $keywords=Options::model()->findByAttributes(array("name" => "keywords")); ?>
      <textarea name="keywords" style="width:400px; height:50px;"><?php echo $keywords->value; ?></textarea></td>
      <td></td>
    </tr>
    <tr class="light">
      <td>Author</td>
      <td>
      <?php $author=Options::model()->findByAttributes(array("name" => "author")); ?>
      <input type="text" name="author" class="" value="<?php echo $author->value; ?>" /></td>
      <td></td>
    </tr>
    <tr class="light">
      <td>Charset</td>
      <td>
      <?php $charset=Options::model()->findByAttributes(array("name" => "charset")); ?>
      <input type="text" name="charset" class="" value="<?php echo $charset->value; ?>" /></td>
      <td></td>
    </tr>
    
    
	<tr class="dark">
      <td colspan="3"><?php echo CHtml::submitButton('Update', array("class" => "btn")); ?></td>
    </tr>
	
</table>
<?php $this->endWidget(); ?>

</div><!-- form -->