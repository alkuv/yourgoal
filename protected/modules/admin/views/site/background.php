<?php $this->pageTitle=Yii::app()->name; ?>


       	<div class="bar">Home &raquo; Change Background & Logo</div>
		<br />

<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 

foreach(Yii::app()->user->getFlashes() as $key => $message) {
	echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}
?>

          <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#333333" class="table">
            <tr>
                <th colspan="2">Update Background & Logo</th>
            </tr>
            
            <tr class="light">
              <td width="120">Background</td>
              <td><?php
			  $bg=Options::model()->findByAttributes(array("name" => "background"));
              $this->widget('application.extensions.colorpicker.EColorPicker', 
              array(
                    'name'=>'colorpicker',
                    'mode'=>'textfield',
                    'fade' => true,
					'value' => $bg->value,
                    'slide' => false,
                    'curtain' => true,
                   )
              );
			  ?>
              </td>
            </tr>
            
           <!-- <tr class="light">
              <td valign="top">Site Logo</td>
              <td>
              <?php $logo=Options::model()->findByAttributes(array("name" => "logo")); ?>
              <input type="file" value="" name="image" /><br />
              <img src="<?php echo Yii::app()->baseUrl; ?>/images/<?php echo $logo->value; ?>" alt="" />
              </td>
            </tr>-->
            
            <tr class="dark">
              <td></td>
              <td><input type="submit" name="yt0" value="Update" class="btn" /></tr>
              
            
          </table>
<?php $this->endWidget(); ?>