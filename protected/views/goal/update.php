 <style>#imageupload{display:none;}.errorSummary{color:red;}

 </style>
 <?php 
 
 $checkbox=unserialize($model->termination);
 //echo '<prE>';

 $stage=array_filter(unserialize($model->stage));
 $stage_description=array_filter(unserialize($model->stage_description));
// print_r($stage);
 $count=count($stage);
 //print_r($model->image);
 
 //echo '</pre>';
 $abhi=0;
 if(is_array($checkbox)){
$abhi= array_sum($checkbox);
 }
//echo '<pre>'; print_r($model); print_r($checkbox); die;
 ?>
 
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
 <?php Yii::app()->clientScript->registerScript('progress'," $('.check-pro').click(function(){ 
              var count=0;
            $('.check-pro').each(function(){            
                if($(this).is(':checked')){                 
                   count += parseInt($(this).val());                   
                } 
            });
             //alert(count);
             if(count>=3)
			 { 
				$('#watge1').addClass('added_color');
				$('#watge1>img').addClass('fair1');
				
				}
              if(count>5){ 
			  
					$('#watge2').addClass('added_color' );
					$('#watge2>img').addClass('good1');
				
				}
              if(count>=10){ 
			  
					$('#watge3').addClass('added_color');
					$('#watge3>img').addClass('perfect1');
				
				}
              if(count<3){ 
				$('#watge1').removeClass('added_color'); 
				$('#watge1>img').removeClass('fair1');
			  }
              if(count<5)
			  { 
				$('#watge2').removeClass('added_color'); 
				$('#watge2>img').removeClass('good1');
				
				}
              if(count<10){ 
			  $('#watge3').removeClass('added_color');
			  $('#watge3>img').removeClass('perfect1');
			  
			  }
            $( '.Progress-bar' ).animate({ 'width': count*20 }, 'slow' ); 
            });")?>

 <?php //echo '<pre>'; print_r($model); echo '</pre>'; ?>
 <script>
     function draftfunction() 
     {
         document.getElementByID("goal-form").submit();
     }
     </script>
 <?php if(isset($_REQUEST['step'])) {$step=$_REQUEST['step'];}?>
 <div class="content addStep-page">
<section class="mainMenu-full">
	<div class="mainMenu-box">
	<div class="section-wrapper clearfix">
	<h3 class="mainMenu-title">
	<span class="big">OBJECTIVES APPENDIX</span>
	<span class="small">3 simple steps and your goal will appear on the Site</span>
	</h3>
	</div>
	</div>

	<div class="mainMenu-tabs-box">
		<div class="section-wrapper clearfix">
		   <div class="stepTab-box">
				<div id="head1" onclick ="tabing(this.id)" class="stepTab-head stepTab-head1 active">
					Step 1:<br>
					<span class="upper" id="DESCRIPTION">DESCRIPTION</span>
				</div>
				<div id="head2" onclick ="tabing(this.id)" class="stepTab-head stepTab-head2">
					Step 2:<br>
					<span class="upper" id="STAGES">STAGES</span>
				</div>
				<div id="head3" onclick ="tabing(this.id)" class="stepTab-head stepTab-head3">
					Step 3:<br>
					<span class="upper" id="TAC">TAGS AND CATEGORIES</span>
				</div>
		   </div>
		</div>
	</div>

</section>
<section class="stepTab-section">
<div class="section-wrapper clearfix">
<div class="stepTab-body">
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'goal-form',
        'htmlOptions'=> array('enctype'=>"multipart/form-data"),
	'enableAjaxValidation'=>false,
)); ?>
<div class="stepTab step1 active<?php //if($step==1) {echo "active";} ?>">


    <?php echo $form->errorSummary($model); ?>
<!--    <select name="Goal[status]">
  
        <option value="...">...</option>
        <option value="...">...</option>
        <option value="...">...</option>
   
    </select>-->
     <?php //echo ZHtml::enumDropDownList( $model,'status'); ?>
                                    <span class="form-label">Name of the destination <b style="color:red">*</b></span>
                                        <?php echo $form->textField($model,'name',array('class'=>inputDef,'maxlength'=>200)); ?>								
                                    <span class="form-label">Desciption of purpose <b style="color:red">*</b></span>
                                    <div class="textareaDef-box">
                                    	<div class="textarea-editor">
                                            <a href="" class="textarea-editor-func func-chars"></a>
                                            <a href="" class="textarea-editor-func func-bold active"></a>
                                            <a href="" class="textarea-editor-func func-italic"></a>
                                            <a href="" class="textarea-editor-func func-textDecor"></a>
                                            <a href="" class="textarea-editor-func func-olist"></a>
                                            <a href="" class="textarea-editor-func func-ulist"></a>
                                            <a href="" class="textarea-editor-func func-link"></a>
                                            <a href="" class="textarea-editor-func func-video"></a>
                                        </div>
                                    	<textarea class="textareaDef" name="Goal[discription]" id="editor1"><?php echo $model->discription; ?></textarea>
                                    </div>
                                    <!--<span class="form-label">Termination Criterion</span>-->
                            <?php //echo $form->textField($model,'termination',array('class'=>inputDef,'maxlength'=>200)); ?>
                                   
                                    <!--<span class="form-label">The First Action</span>-->
			<?php //echo $form->textField($model,'action',array('class'=>inputDef,'maxlength'=>200)); ?>
                                   
                                     <span class="form-label corr-mar">Is it really your goal within the goal?</span>  
                                      <div class="Progress-wrapper" >
                                      <div class="Progress-bar" style="width:<?php echo 20 *$abhi ; ?>px;"></div>
										  <span id="watge1" <?php if($abhi>=3){ ?>class="added_color"<?php } ?>><img class="fair <?php if($abhi>=3){ ?> fair1 <?php }?>" src="<?php echo Yii::app()->baseUrl; ?>/images/tick.png"/><br />Fair</span>
										  <span id="watge2" <?php if($abhi>=5){ ?>class="added_color"<?php } ?>><img class="good <?php if($abhi>=5){ ?> good1 <?php }?>" src="<?php echo Yii::app()->baseUrl; ?>/images/tick.png"/><br />Good</span>
										  <span id="watge3" <?php if($abhi>=10){ ?>class="added_color"<?php } ?>><img class="perfect <?php if($abhi>=10){ ?> perfect1 <?php }?>" src="<?php echo Yii::app()->baseUrl; ?>/images/tick.png"/><br />Perfect</span>
									  </div>
                                     </br>
                                      <div class="labelMod clearfix">
                                          <input class="check-pro" <?php if(array_key_exists("1",$checkbox)) { ?>checked="checked"<?php } ?> value="2" type="checkbox" name="Goal[checkbox][1]"/>                                            
                                            <span class="info-box">
                                                <div class="splach-info">
                                                    Option a 
                                                </div>
                                            </span>
                                          <span class="form-label">option a</span>
                                        </div>
                                     
                                        <div class="labelMod clearfix">
                                          <input class="check-pro" <?php if(array_key_exists("2",$checkbox)) { ?>checked="checked"<?php } ?>value="2"  type="checkbox" name="Goal[checkbox][2]"/>                                            
                                            <span class="info-box">
                                                <div class="splach-info">
                                                    option b 
                                                </div>
                                            </span>
                                          <span class="form-label">option b</span>
                                        </div>
                                     
                                        <div class="labelMod clearfix">
                                          <input class="check-pro" <?php if(array_key_exists("3",$checkbox)) { ?>checked="checked"<?php } ?> value="1"  type="checkbox" name="Goal[checkbox][3]"/>                                            
                                            <span class="info-box">
                                                <div class="splach-info">
                                                    option c
                                                </div>
                                            </span>
                                          <span class="form-label">option c</span>
                                        </div>
                                     
                                        <div class="labelMod clearfix">
                                          <input class="check-pro" <?php if(array_key_exists("4",$checkbox)) { ?>checked="checked"<?php } ?> value="1"  type="checkbox" name="Goal[checkbox][4]"/>                                            
                                            <span class="info-box">
                                                <div class="splach-info">
                                                   option d
                                                </div>
                                            </span>
                                          <span class="form-label">option d</span>
                                        </div>
                                     
                                        <div class="labelMod clearfix">
                                          <input class="check-pro" <?php if(array_key_exists("5",$checkbox)) { ?>checked="checked"<?php } ?> value="2"  type="checkbox" name="Goal[checkbox][5]"/>                                            
                                            <span class="info-box">
                                                <div class="splach-info">
                                                    option e
                                                </div>
                                            </span>
                                          <span class="form-label"> option e</span>
                                        </div>
                                     
                                        <div class="labelMod clearfix">
                                          <input class="check-pro" <?php if(array_key_exists("6",$checkbox)) { ?>checked="checked"<?php } ?>value="1"  type="checkbox" name="Goal[checkbox][6]"/>                                            
                                            <span class="info-box">
                                                <div class="splach-info">
                                                  option f
                                                </div>
                                            </span>
                                          <span class="form-label">option f</span>
                                        </div>
                                     
                                     
                                        <div class="labelMod clearfix">
                                          <input class="check-pro" <?php if(array_key_exists("7",$checkbox)) { ?>checked="checked"<?php } ?>value="1"  type="checkbox" name="Goal[checkbox][7]"/>                                            
                                            <span class="info-box">
                                                <div class="splach-info">
                                                  option g
                                                </div>
                                            </span>
                                          <span class="form-label">option g</span>
                                        </div>
                                     
                                    <span class="form-label corr-mar">Add a Photo <b style="color:red">*</b></span>
                                    <div class="addingPhotos-box">
                                    	<div style="width:auto" class="addingPhoto">
                                        	<img src="<?php echo Yii::app()->baseUrl."/".$model->image;?>" width="77" height="52" alt="" />
                                         
                                        </div>
                                    	<!--<div href="" class="addingPhoto">
                                        	<img src="img/tmp/img2.png" width="77" height="52" alt="" />
                                            <a href="" class="addingPhoto-del">
                                            	<img src="img/adding-img-x.png" width="12" height="12" alt="" />
                                            </a>
                                        </div>-->
                                        <?php //$model->file=$model->image; $model->save(false);?>
                                    	<a href="javascript:void(0)" onclick="$('#imageupload').click()" class="addingPhoto-link">Add a picture</a>
										<?php //echo CHtml::activeFileField($model, 'file' ,array('id'=>'imageupload',)); ?>
										<input type="hidden" name="Goal[image]" value="<?php echo $model->image;?>" id="ytimageupload">
										<input type="file" name="Goal[image]" value="<?php echo $model->image;?>" id="imageupload">

                                    </div>
                                    <div class="stepTab-nav">
									<?php //echo CHtml::submitButton($model->isNewRecord ? 'Next' : 'Next',array('class'=>'stepTab-next'));  ?>
									
                                    <a href="javascript:void(0)" class="stepTab-next">Next</a>
                                    <?php //echo CHtml::submitButton($model->isNewRecord ? 'Draft' : 'Draft',array('class'=>'stepTab-draft'));  ?>
                                    <a href="javascript:void(0)" onclick="document.getElementById('goal-form').submit()" class="stepTab-draft">Draft</a>
                                    </div>
		
		
						</div><!-- END step1-->

                        <div class="stepTab step2">
                                    <div class="stepTab-stage clearfix">
                                    	<span class="stepTab-stage-title">Step 1</span>
<!--                                        <a href="" class="stepTab-stage-del">Delete</a>-->
                                        <div class="clearfix"></div>
                                        <hr />
                                        <div class="labelMod clearfix">
                                            <span class="form-label">Name of phase</span>
                                            <span class="info-box">
                                                <div class="splach-info">
                                                    Name of the Phase
                                                </div>
                                            </span>
                                        </div>
                                        <input type="text" name="Goal[stage][]" value="<?php echo $stage[0]; ?>" class="inputDef"/>
                                        

                                        <span class="form-label">Description</span>
                                        <div class="textareaDef-box">
                                            <div class="textarea-editor">
                                                <a href="" class="textarea-editor-func func-chars"></a>
                                                <a href="" class="textarea-editor-func func-bold"></a>
                                                <a href="" class="textarea-editor-func func-italic"></a>
                                                <a href="" class="textarea-editor-func func-textDecor"></a>
                                                <a href="" class="textarea-editor-func func-olist"></a>
                                                <a href="" class="textarea-editor-func func-ulist"></a>
                                                <a href="" class="textarea-editor-func func-link"></a>
                                                <a href="" class="textarea-editor-func func-video"></a>

                                            </div>
                                            <textarea class="textareaDef" name="Goal[description][]"id="editor2"><?php echo $stage_description[0]; ?></textarea>
                                        </div>

                                        <!--<a href="" class="stepTab-stage-addImg">Add picture</a>
                                        <a href="" class="stepTab-stage-stagePrice">Add value stage</a>--> 
                                 	</div>

                                    
                                       <div id="myDiv">
									   <?php $j=2; for($i=1;$i<$count;$i++) { ?>
									   
									   <div class="stepTab-stage clearfix">
                                    	<span class="stepTab-stage-title">Steps <?php echo $j;?></span>
                                        
                                        <div class="clearfix"></div>
                                        <hr />
                                        <div class="labelMod clearfix">
                                            <span class="form-label">Name of Phase</span>
                                        </div>
                                        <input type="text" name="Goal[stage][]" value="<?php echo $stage[$i];?>" class="inputDef"/>
                                        <span class="form-label">Description</span>
                                        <div class="textareaDef-box">                                            
                                            <textarea class="textareaDef" name="Goal[description][]" style="padding-top:0px;"><?php echo $stage_description[$i];?></textarea>
                                        </div>                                     
										</div>
									   <?php //echo $stage_description[$i]; echo '<br>';?>
									   <?php $j++; } ?>
                                	
                                    </div>
                           
                           
                                    <hr class="corr_hr" />

                                    <a href="javascript:void(0)" onclick="return add();" class="stageAdd">Add Stage</a>

                                    <div class="clearfix"></div>


                                    

                                    <div class="stepTab-nav">

                                    	<a href="" class="stepTab-prev">

                                        	<img src="<?php echo Yii::app()->baseUrl?>/images/back-btn.png" width="17" height="28" alt="back" />

                                        </a>

                                    

                                    	<a href="" class="stepTab-next">Next</a>
										
                                        <?php //echo CHtml::submitButton($model->isNewRecord ? 'Draft' : 'Draft',array('class'=>'stepTab-draft'));  ?>
                                   	<a  href="javascript:void(0)" onclick="document.getElementById('goal-form').submit()" class="stepTab-draft">Draft</a>

                                    </div>

                                </div><!-- END step2-->



                           

                               <div class="stepTab step3 ">
                                   <div class="selects-line clearfix">
                                       <div class="select-box">
                                        <span class="form-label">Category</span>
                                       <select class="selectDef" name="Goal[category_id]">
                                       <?php                                        
                                      $categorys=Categories::model()->findAll();                                  
                                      foreach($categorys as $category) {  ?>
                                       <option value="<?php echo $category->id;?>"><?php echo $category->category;?></option>
                                           <?php   } ?>
                                        </select>
                                        </div>
                                       <div class="select-box">
                                        <span class="form-label corr_float">Status</span>
                                        <?php echo ZHtml::enumDropDownList( $model,'status' ,array('class'=>'selectDef')); ?>
                                        </div>
                                    </div>
                                    <div class="selects-line clearfix">
                                    	<div class="select-box">
                                        <span class="form-label corr_float">Purpose visible</span>
                                        <?php echo ZHtml::enumDropDownList( $model,'visibility' ,array('class'=>'selectDef')); ?>
                                        </div>
                                        <div class="select-box">
                                            <span class="form-label">The goal can comment</span>
                                                <?php echo ZHtml::enumDropDownList( $model,'comment_status' ,array('class'=>'selectDef')); ?>
                                        </div>
                                    </div>

                                    

                                    

                                    

                        <span class="form-label">Tags</span>
                        <?php echo  $form->textField($model,'tags',array('class'=>'inputDef corr_marBtm'));  ?>
                    
                                   <!-- <input type="text" class="inputDef corr_marBtm"/>-->

                                    <span class="btm-label">                                        
                                        A maximum of 30 keywords. Tags should all be in lower case ans separatd by commas.
                                        example: Mars,deoxyribonucleic, mysticism,patch
                                    </span>

<!--                                    <hr class="corr_hr" />

                                    <a href="javascript:void(0)" class="blue-link">Add the date of completion</a>

                                    or&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="blue-link">Timeframe</a>-->
                                    <div class="stepTab-nav">
                                    	<a href="" class="stepTab-prev">

                                        	<img src="<?php echo Yii::app()->baseUrl?>/images/back-btn.png"width="17" height="28" alt="back" />

                                        </a>

                                        
                                        
                                   	<a href="javascript:void(0)"  onclick="document.getElementById('goal-form').submit()" class="stepTab-next">Post</a>
                                        <?php //echo CHtml::submitButton($model->isNewRecord ? 'Post' : 'Post',array('class'=>'stepTab-next'));  ?>

                                    	<a href="javascript:void(0)"  onclick="document.getElementById('goal-form').submit()" class="stepTab-draft">Draft</a>
                                        <a href="<?php echo  Yii::app()->createAbsoluteUrl("/goal/goaldelete/id/$model->id") ?>" class="stepTab-draft">Delete</a>
                                        <?php // echo CHtml::submitButton($model->isNewRecord ? 'Draft' : 'Draft',array('class'=>'stepTab-draft'));  ?>

                                    </div>

                                </div><!-- END step3-->
                               

                           </div>  <?php $this->endWidget(); ?>
                        </div></section></div><!--END content-->
            <div id="theValue"> </div>
        <script>
var $a = 1;
var i=0;
var j=1;

function add() 
    { 
        var category_name = document.getElementById('category_name').innerHTML;
        var n = document.getElementById('myDiv');
        var numbr = document.getElementById('theValue');
        var toatal= parseInt(document.getElementById('total').value);
        if(toatal<10) { var inc=++toatal;
            document.getElementById('total').value=inc;
        
        var num =$a;   
        var stage=++num;
        numbr.value = num;                                    
        var newdiv = document.createElement('div');           
        var div_Id = 'my'+num+'Div'; 
        var pid='pid'+ num;
        newdiv.setAttribute('id',div_Id);    
        newdiv.innerHTML = 
		"<div class='form-group' >"+ " <b class='stepTab-stage-title' style='left: 70px;position: relative;'>"+stage+"</b><a href='javascript:void(0)' class='stepTab-stage-del' onClick=\"Clear('" + div_Id + "');\" value='remove'>Delete</a>" +category_name +"</div></div>"+   
             
                " <span id='"+ pid +"'> </span>"; 
        n.appendChild(newdiv);
        $a++;
        return false;
        }
        else {
            alert("You can't add more than 10 stages");
        }
    }
function Clear(did)
{
     var toatal= parseInt(document.getElementById('total').value);
      var inc=--toatal;
            document.getElementById('total').value=inc;
    document.getElementById(did).innerHTML="";
    return false;
}


</script>
<input  type="hidden" id="total" value="<?php echo $count ?>"/>
<div class="stepTab-stage clearfix" id="category_name" style="display:none">
                                    	<span class="stepTab-stage-title">Steps </span>
                                        
                                        <div class="clearfix"></div>
                                        <hr />
                                        <div class="labelMod clearfix">
                                            <span class="form-label">Name of Phase</span>
                                        </div>
                                        <input type="text" name="Goal[stage][]" class="inputDef"/>
                                        <span class="form-label">Description</span>
                                        <div class="textareaDef-box">                                            
                                            <textarea class="textareaDef" name="Goal[description][]" style="padding-top:0px;"></textarea>
                                        </div>                                     
</div>