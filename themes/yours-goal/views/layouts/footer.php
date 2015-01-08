<footer class="siteFooter">
    <section class="yellow-line">
    </section>
    <div class="section-wrapper clearfix">
    <div class="site-map-box clearfix">
    <div class="site-map-block">
    <span class="site-map-title"><?php echo Yum::t("Основные функции") ?></span>
    <ul class="clear-ul site-map-list">
            <li><a href="<?php echo Yii::app()->createUrl("site/textpage"); ?>"><?php echo Yum::t("TextPage"); ?></a></li>
            <li><a href="<?php echo Yii::app()->createUrl("site/textpage"); ?>"><?php echo Yum::t("About Us"); ?></a></li>
            <li><a href="<?php echo Yii::app()->createUrl("site/textpage"); ?>"><?php echo Yum::t("Contact Us"); ?></a></li>
            <li><a href="<?php echo Yii::app()->createUrl("site/textpage"); ?>"><?php echo Yum::t("Faq"); ?></a></li>
    </ul>
    </div>
    <div class="site-map-block">
    <span class="site-map-title"><?php echo Yum::t("Помощь") ?></span>
    <ul class="clear-ul site-map-list">
            <li><a href="<?php echo Yii::app()->createUrl("site/help"); ?>"><?php echo Yum::t("Help"); ?></a></li>
            <li><a href="<?php echo Yii::app()->createUrl("feedback/index"); ?>"><?php echo Yum::t("Feedback") ?></a></li>
            <li><a href="<?php echo Yii::app()->createUrl("goal/all"); ?>"><?php echo Yum::t("Goals") ?></a></li>
            <li><a href=""><?php echo Yum::t("Pinterest") ?></a></li>
    </ul>
    </div>
    <div class="site-map-block">
    <span class="site-map-title"><?php echo Yum::t("Подписка") ?></span>
    <ul class="clear-ul site-map-list">
             <li><a href=""><?php echo Yum::t("Newsletter") ?></a></li>
            <li><a href=""><?php echo Yum::t("Twitter") ?></a></li>
            <li><a href=""><?php echo Yum::t("Facebook") ?></a></li>
            <li><a href=""><?php echo Yum::t("Pinterest") ?></a></li>
    </ul>
    </div>
    <div class="site-map-block">
    <span class="site-map-title"><?php echo Yum::t("subcribe") ?></span>
    <ul class="clear-ul site-map-list">
            <li><a href=""><?php echo Yum::t("Newsletter") ?></a></li>
            <li><a href=""><?php echo Yum::t("Twitter") ?></a></li>
            <li><a href=""><?php echo Yum::t("Facebook") ?></a></li>
            <li><a href=""><?php echo Yum::t("Pinterest") ?></a></li>
    </ul>
    </div>
    </div>
    <div class="footer-logo-box">
            <a href="mainpage.html" class="header-logo">YOUR<span class="yellow">GOAL</span></a><br>
            &copy 2014  All rights reserved
    </div>
</div>

				

           </footer>
        <?php    $actionId = strtolower($this->getAction()->getId());
		if($actionId=="view" || $actionId=="dashboard") {
		?>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<?php } ?>


<script type="text/javascript">
    
    function categoies(id)
    {    
        if(id!="") 
        {
            
            var queryParameters = {}, queryString = location.search.substring(1),
               re = /([^&=]+)=([^&]*)/g, m;       
           while (m = re.exec(queryString)) {
               queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);             
           }
             queryParameters['cat'] = id;
           location.search = $.param(queryParameters);           
        }
        
        
         /*  if(url.indexOf("sRegion_radius")!='-1')
          {
            var queryParameters = {}, queryString = location.search.substring(1),
               re = /([^&=]+)=([^&]*)/g, m;       
           while (m = re.exec(queryString)) {
               queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);             
           }
           queryParameters['sRegion'] = region;         
           queryParameters['sRegion_radius'] = region;         
           location.search = $.param(queryParameters);
          }
          else if(url.indexOf("sRegion")!='-1')
          {
              var queryParameters = {}, queryString = location.search.substring(1),
               re = /([^&=]+)=([^&]*)/g, m;       
           while (m = re.exec(queryString)) {
               queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);             
           }
           queryParameters['sRegion'] = region; 
           location.search = $.param(queryParameters);
          } */
        
    }
    
	function subscribe(id)
	{
		var login_id =$("#user_login").val();
		if(login_id=="no")
		{
			var r = confirm("Please Login to Subscribe!");
			if (r == true) 
			{
				window.location.href="<?php echo Yii::app()->createAbsoluteUrl("/user/login"); ?>";
			}
		}
                else 
                {
                
                $.ajax({ 
				type:'get',
				url:"<?php echo Yii::app()->createAbsoluteUrl("/goal/subscribe"); ?>",
			  
                            data:{               
                                  type:"subscribe",
                                  login_id:login_id,
                                  goal_id:id
                                 },

			success:function(value) {
                                
                                if(value==2) 
                                {
                                    alert("You Already Subscribe for this Goal");
                                }
                                else{                                    
                                    if($( "#subcribe_"+id ).hasClass( "subscibewithoutlogin" ))
                                    {
                                        $( "#subcribe_"+id ).removeClass( "subscibewithoutlogin" );
                                        $( "#subcribe_"+id ).addClass( "subscibe" );
                                        alert("Thanks for Subscribe");
                                    }
                                }
					
			
                        }
  
				});
                
                
                }
		
	}
        
        
        /*love function */
        
        
        function love(id)
	{      
                $.ajax({ 
				type:'get',
				url:"<?php echo Yii::app()->createAbsoluteUrl("/goal/love"); ?>",
			 // dataType:'json',
                            data:{               
                                  type:"love",
                                  login_id:"<?php echo str_replace(".","",Yii::app()->request->getUserHostAddress());?>",
                                  goal_id:id
                                 },

			success:function(value) {
                                
                                if(value==2) 
                                {
                                    if($( "#love_"+id ).hasClass( "purpose-cnt" ))
                                    {
                                        $( "#love_"+id ).removeClass( "purpose-cnt" );
                                        $( "#love_"+id ).addClass( "purpose-cnt_without" );
                                        var count=parseInt($("#love_"+id).html());
                                        count=count-1;
                                       // alert(count);
                                         $("#love_"+id).html('');
                                        $("#love_"+id).html(count);
                                       
                                    }
                                }
                                else{                                    
                                    if($( "#love_"+id ).hasClass( "purpose-cnt_without" ))
                                    {
                                        $( "#love_"+id ).removeClass( "purpose-cnt_without" );
                                        $( "#love_"+id ).addClass( "purpose-cnt" );
                                        var count=parseInt($("#love_"+id).html());
                                        count=count+1;
                                       // alert(count);
                                         $("#love_"+id).html('');
                                        $("#love_"+id).html(count);
                                       // alert("Thanks for Like");;
                                    }
                                }
					
			
                        }
  
				});
                
               
		
	}
        
       function complete(id) 
	   {
		   
		   var r = confirm("Are you want to complete that goal?");
			if (r == true) 
			{
						   
		    $.ajax({ 
				type:'get',
				url:"<?php echo Yii::app()->createAbsoluteUrl("/goal/complete"); ?>",
			 // dataType:'json',
                            data:{             
                                 
                                  goal_id:id
                                 },

			success:function(value) {
               
					window.location.href="<?php echo Yii::app()->createAbsoluteUrl("/goal/dashboard"); ?>";
			
                        }
  
				});
           }
		}
        
</script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.8.custom.min.js" type="text/javascript"></script>

<!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.4.2.min.js" type="text/javascript"></script>-->
<script type="text/javascript">
		$(document).ready(function(){
			  $("#mainDragContainer .sortable-list").sortable({
				 connectWith: '#mainDragContainer .sortable-list',
				receive: function( event, ui ) {
				
				var id = ui.item.attr('id');
				var block = $(this).parent().attr('id');
				  var block_type;
				  //alert(id);
				  //alert(block);
				  
				if(block == "activeGoal")
				{
				block_type="Active";
				//	alert("In active Goal");
					
				}
				
				if(block == "draftGoal")
				{
				block_type="Draft";
					//alert("In Draft Goal");
				}
				
				 if(block == "completeGoal")
				{
				block_type="Finished";
					//alert("In complete Goal");
					
				}
				 if(block == "failedGoal")
				{
				block_type="Inactive";
					//alert("In failed Goal");
					
				}
				  
				  $.ajax({ 
					type:'get',
					url:"<?php echo Yii::app()->createAbsoluteUrl("/goal/Status"); ?>",
					// dataType:'json',
					data:{             
					status:block_type,
					goal_id:id
					},

					success:function(value) {
						if(value==1)
						{
								alert("Goal status has been changed to "+block_type);
						}
					}

				});  
		}	
			 
			 });  
			  
		});
		function deleteGoal(goalId)
		{
			var r = confirm("Are you want to delete that goal!");
			if (r == true) 
			{
			 
				 $.ajax({ 
					type:'get',
					url:"<?php echo Yii::app()->createAbsoluteUrl("/goal/deleteGoal"); ?>",					
					data:{goal_id:goalId},
					success:function(value) {
						if(value==1)
						{
								alert("Goal deleted Sucessfully");
								$("#"+goalId).hide();
						}
					}

				}); 
			}
			 
		}
              
		
	</script>

<!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/enscroll-0.4.0.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
     var scroll= $.noConflict();
                 scroll('.www').enscroll({ 
                showOnHover: true,
                verticalTrackClass: 'track1',
                verticalHandleClass: 'handle1'
            });
        });
    </script>-->