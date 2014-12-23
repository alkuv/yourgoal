<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/stylePrivate.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/images/backend/favicon.ico" rel="icon" type="image/x-icon" />
    <?php $model=Options::model()->findByAttributes(array("name" => "background")); ?>
	<style>body {background:#<?php echo $model->value; ?>;} </style>
</head>

<body>

<div class="wra">
	<!--header-->
    <div class="header">
        <?php echo "herer";?>
    	<div class="w1000">
        	<div class="logo"><a href="<?php echo Yii::app()->createUrl('site/index'); ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/backend/logo.png" alt="" /></a></div>
            <div class="name">
           	 <img src="<?php echo Yii::app()->baseUrl; ?>/images/backend/admin_name.png" width="467" height="82" alt="" /><br />
            	 <!--<a href="<?php echo Yii::app()->createUrl('private/users/view/id/' . Yii::app()->user->user_id ); ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/backend/icon/user.png" alt="" width="15" height="15" border="0" /> <strong>Profile</strong></a>-->
                 <a href="<?php echo Yii::app()->createUrl('site/setting'); ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/backend/icon/setting.png" alt="" width="18" height="15" border="0" /> <strong>Setting</strong></a>
                 <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/backend/icon/sign_out.png" width="15" height="15" alt="" /> <strong>Logout</strong></a>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <!--end header-->
    <div class="w1000">
        <!--left-->
        <div class="left">
        	
            
            <?php LeftBar::showMenu(); ?>
			
            
        </div>
        <!--end left-->
        <!--right-->
      <div class="right">
        
          <?php echo $content; ?>

      </div>
        <!--end right-->
        <div class="clear"></div>
    </div>
</div>
	
	

</body>
</html>
