	<script>
		function like(postid){

			$.post( "/blogposts/like", { postid: postid }, function( data ) {
				$( "span#like_"+postid).html( data.count );
			}, "json");
		}
	</script>
		<!-- BEGIN l -->

		<div class="l">
			<div class="l-col1">
				<!-- BEGIN user -->
				<div class="user">
					<div class="user__img">
						<div class="user__field">
						<?php if(!empty($data->user->avatar)){ ?>
								<img src="<?php echo $data->user->avatar; ?>" alt="img">
						<?php }else{ ?>
								<img src="img/user.png" alt="img">
						<?php } ?>
							
						</div>
					</div>
					<?php //var_dump($data->user->username); ?>
					<div class="user__name"><?php echo $data->user->username; ?>,</div>
					<div class="user__text">повелитель фиолетовых лобстеров</div>
					<!-- BEGIN like -->
					<div class="like is-active"><span id="like_<?php echo $data->id; ?>"><?php echo BlogLikes::getLikesCount($data->id); ?></span><i class="ico ico_like" onClick="like(<?php echo $data->id; ?>);return false;"></i></div>
					<!-- END like -->
				</div>
				<!-- END user -->
			</div>
			<div class="l-col2">
				<!-- BEGIN article -->
				<article class="article">
					<!-- BEGIN img -->
					<div class="img">
						
						<?php 
						$content = preg_match("/<(img|image)[\s]+[^>]*src=['\"]?([^'\"\s>]+)['\"]?[^>]*>/is", 
							 $data->description, $result); 
						if($content){ ?>
							<div class="date">
								<div class="date__day"><?php echo date("d", strtotime($data->created)); ?></div>
								<div class="date__month"><?php echo date("M", strtotime($data->created)); ?></div>
							</div>
						<?php echo $result[0]; } ?>
						<!-- <img src="img/img-2.png" alt="img"> -->
					</div>
					<!-- END img -->
					<!-- BEGIN tags -->
					<?php 
						$tags = Tags::getTagsArray($data->id);
						if(!empty($tags)):
					?>
					<ul class="tags">
						<li class="tags__item">Tags:</li>
						<?php 
						$i = 1;
						foreach ($tags as $tag) {  ?>
							<li class="tags__item"><a href="/blog?tag=<?php echo trim($tag->tag); ?><?php if(isset($_GET['category'])) echo '&category='.$_GET['category']; ?><?php if(isset($_GET['date'])) echo '&date='.$_GET['date']; ?>"><?php echo $tag->tag; ?></a><?php if(count($tags) != $i) echo ","; ?></li>
						<?php 
						++$i;
						}	?>
					</ul>
					<?php endif; ?>
					<!-- END tags -->
					<h1><?php echo $data->title; ?></h1>

					<p><?php echo BlogPosts::getShortDescription($data->id)."...";?></p>
					<div class="row">
						<a href="<?php echo "/blog/".$data->url; ?>" class="btn">Читать дальше</a>
						<!-- BEGIN soc -->
						<ul class="soc">
							<li><a href="http://vk.com/share.php?url=<?php echo 'http://'.$_SERVER['SERVER_NAME']."/blog/".$data->url; ?>&noparse=true&description=<?php echo BlogPosts::getShortDescription($data->id);?>&title=<?php echo $data->title; ?>&image=http://yourgoal.dev/images/img-2.png" target="_blank" class="ico ico_vk"></a></li>
							<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo 'http://'.$_SERVER['SERVER_NAME']."/blog/".$data->url; ?>&p[title]=<?php echo $data->title; ?>&p[summary]=<?php echo BlogPosts::getShortDescription($data->id);?>&src=http://yourgoal.dev/images/img-2.png" target="_blank" class="ico ico_f"></a></li>
							<li><a href="https://twitter.com/home?status=<?php echo 'http://'.$_SERVER['SERVER_NAME']."/blog/".$data->url; ?>" target="_blank" class="ico ico_tw"></a></li>
							<li><a href="https://plus.google.com/share?url=<?php echo 'http://'.$_SERVER['SERVER_NAME']."/blog/".$data->url; ?>" target="_blank" class="ico ico_g"></a></li>
						</ul>
						<!-- END soc -->
					</div>
				</article>
				<!-- END article -->
			</div>
			<!-- BEGIN pager -->
		</div>
		<!-- END l -->