<?php $this->beginContent('//layouts/main'); ?>
      <div class="row-fluid">
        <div class="span3">
         <?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>array(
							array('label'=>'Keyword Position', 'url'=>array('/KeywordPosition'), 'active'=>$this->id == 'keywordposition'?true:false ),
							array('label'=>'DMCA Scanner', 'url'=>array('/DmcaScanner'), 'active'=>$this->id == 'dmcascanner'?true:false ), 
//							array('label'=>'Login', 'url'=>array('/login'), 'visible'=>Yii::app()->user->isGuest),
							array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/login/logout'), 'visible'=>!Yii::app()->user->isGuest)
						),
				'htmlOptions'=>array('class'=>'sidebar'),
                            'activeCssClass'	=> 'active',
			));
			$this->endWidget();
		?>
		</div><!-- sidebar span3 -->

	<div class="span9">
		<div class="main">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>
