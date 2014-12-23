<?php $this->pageTitle=Yii::app()->name; ?>


       	<div class="bar">
        Static &raquo; Links
        </div>
		<br />
        <div class="heading">Links</div>
        <form name="static" method="post" action="">
          <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#333333" class="table">
            <tr>
              <td>
			  <?php 
			  $this->widget('application.extensions.cleditor.ECLEditor', array(
					'name'=>'links',
					'value'=>$model->links,
					'options'=>array(
						'width'=>'680',
						'height'=>450,
						'useCSS'=>true,
					),
				));
			  ?>
			  </td>
            </tr>
            <tr>
             <td><input type="submit" name="button" value="Update" class="btn" /></td>
            </tr>
          </table>
        </form>
        
<script type="text/javascript">
    document.getElementById('video_upload').style.display = 'none';
</script>