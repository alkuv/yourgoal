	<script>
		function scroll(){
		    $('html, body').animate({
		        scrollTop: $("#blog-comments-createcomment-form").offset().top
		    }, 500);
		}
		function like(postid){

			$.post( "/blogposts/like", { postid: postid }, function( data ) {
				$( "span#like_"+postid).html( data.count );
			}, "json");
		}
	</script>

	<!-- BEGIN filter -->
	<div class="filter">
		<!-- BEGIN wrapper -->
		<div class="wrapper">
			<div class="filter__text">Your Goal <strong>Blog</strong></div>
			<div class="filter__right">
				<div class="filter__text-yellow">BROWSE BY</div>
				<div class="filter__browse">
					<ul class="filter__select select">
						<li class="select__text">
							<span>
							<?php if(isset($_GET['category'])) {
								echo Categories::getCategoryName($_GET['category']); 
								}else {
									echo "Category"; } ?>
							</span>
							<ul class="select__list">
							<?php foreach ($category as $cat) { ?>
								<li><a href="/blog?category=<?php echo $cat->id; ?><?php if(isset($_GET['tag'])) echo '&tag='.$_GET['tag']; ?><?php if(isset($_GET['date'])) echo '&date='.$_GET['date']; ?>"><?php echo $cat->category; ?></a></li>
							<?php } ?>
							</ul>
						</li>
					</ul>
					<ul class="filter__select select">
						<li class="select__text">
							<span>
							<?php if(isset($_GET['date'])){
									echo $_GET['date'];
								} else{
									echo "Archives";
								} ?>
							</span>
							<ul class="select__list">
							<?php foreach ($archive as $dates) { ?>
								
							<li><a href="/blog?date=<?php echo $dates['month'].'-'.$dates['year'];?><?php if(isset($_GET['tag'])) echo '&tag='.$_GET['tag']; ?><?php if(isset($_GET['category'])) echo '&category='.$_GET['category']; ?>"><?php echo $dates['month'].'-'.$dates['year'];?></a></li>
							<?php } ?>

							</ul>
						</li>
					</ul>
					<ul class="filter__select select">
						<li class="select__text">
							<span>
							<?php if(isset($_GET['tag'])){
								echo $_GET['tag'];
								}else{
									echo "Tags";
									} ?>
							</span>
							<ul class="select__list">
							<?php foreach ($tags as $tag) { ?>
								<li><a href="/blog?tag=<?php echo trim($tag->tag); ?><?php if(isset($_GET['category'])) echo '&category='.$_GET['category']; ?><?php if(isset($_GET['date'])) echo '&date='.$_GET['date']; ?>"><?php echo trim($tag->tag); ?></a></li>
							<?php } ?>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- END wrapper -->
	</div>
	<!-- END filter -->
	<!-- BEGIN wrapper -->
	<div class="wrapper">
		<!-- BEGIN l -->
		<div class="l">
			<div class="l-col1">
				<!-- BEGIN user -->
				<div class="user">
					<div class="user__img">
						<div class="user__field">
						<?php if(!empty($model->user->avatar)){ ?>
								<img src="/<?php echo $model->user->avatar; ?>" alt="img">
						<?php }else{ ?>
								<img src="/img/user.png" alt="img">
						<?php } ?>
						</div>
					</div>
					<?php //var_dump($model->user->username); ?>
					<div class="user__name"><?php echo $model->user->username; ?>,</div>
					<div class="user__text">повелитель фиолетовых лобстеров</div>
					<!-- BEGIN like -->
					<div class="like is-active"><span id="like_<?php echo $model->id; ?>"><?php echo BlogLikes::getLikesCount($model->id); ?></span><i class="ico ico_like" onClick="like(<?php echo $model->id; ?>);return false;"></i></div>
					<!-- END like -->
				</div>
				<!-- END user -->
			</div>
			<div class="l-col2">
				<!-- BEGIN article -->
				<article class="article article_in">
					<h1><?php echo $model->title; ?></h1>
					<div>
						<?php echo $model->description; ?>

					</div>
				</article>
				<!-- END article -->
				<div class="row row_mod">
					<!-- BEGIN tags -->
					<?php 
						$tags = Tags::getTagsArray($model->id);
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
					<!-- BEGIN soc -->
					<ul class="soc">
						<li><a href="http://vk.com/share.php?url=<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>&description=<?php echo BlogPosts::getShortDescription($model->id);?>&title=<?php echo $model->title; ?>" target="_blank" class="ico ico_vk"></a></li>
						<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" target="_blank" class="ico ico_f"></a></li>
						<li><a href="https://twitter.com/home?status=<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" target="_blank" class="ico ico_tw"></a></li>
						<li><a href="https://plus.google.com/share?url=<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" target="_blank" class="ico ico_g"></a></li>
					</ul>
					<!-- END soc -->
				</div>
			</div>
		</div>
		<!-- END l -->
		<!-- BEGIN pager -->
		<div class="pagers">
			<?php if(!empty($prevpost)): ?>
				<a href="/blog/<?php echo $prevpost[0]['url']; ?>" class="pagers__prev"><?php echo $prevpost[0]['title']; ?></a>
			<?php endif; ?>
			<?php if(!empty($nextpost)): ?>
				<a href="/blog/<?php echo $nextpost[0]['url']; ?>" class="pagers__next"><?php echo $nextpost[0]['title']; ?></a>
			<?php endif; ?>
		</div>
		<!-- END pager -->
		<!-- BEGIN commentsBox -->
		<div class="people-pager-side commentMod comments">
		<?php if(!Yii::app()->user->isGuest): ?>
			<h2 class="comment-title">Комментировать</h2>
			<div class="commentForm-box clearfix">

					<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'blog-comments-createcomment-form',
						// Please note: When you enable ajax validation, make sure the corresponding
						// controller action is handling ajax validation correctly.
						// See class documentation of CActiveForm for details on this,
						// you need to use the performAjaxValidation()-method described there.
						'enableAjaxValidation'=>false,
					)); ?>
							<?php echo $form->errorSummary($commentmodel); ?>
							<?php echo $form->textArea($commentmodel,'comment', array('class' => 'textareaDef')); ?>
							<?php echo $form->error($commentmodel,'comment'); ?>

							<?php echo $form->hiddenField($commentmodel,'answer_id', array('id' => 'answer_id')); ?>

							<?php echo CHtml::submitButton('Отправить', array('class' => 'inputDefBtn')); ?>

					<?php $this->endWidget(); ?>

			</div>
		<?php endif; ?>
			<div class="commentsBox">
			
			<?php foreach ($comments as $comment){ 
				$subcomments = BlogComments::getSubComments($comment->bp_id, $comment->id);
				//var_dump($subcomment);
				?>

				<div class="comment-item clearfix">
					<div class="clearfix">
						<a href="" class="user-img-box">
							<img src="/<?php echo $comment->user->avatar; ?>" width="75" height="75" alt="">
						</a>
						<div class="comment-body">
							<div class="userComment-info">
								<a href="/profile/profile/views/id/<?php echo $comment->user->id; ?>" class="userComment-name"><?php echo $comment->user->username; ?></a>,  
								<span class="userComment-date"><?php echo date("d F Y, H:i", strtotime($comment->created)); ?></span>
							</div> 
							<p class="userComment-text"><?php echo $comment->comment; ?></p>
							<a href="" onClick="$('#answer_id').val(<?php echo $comment->id; ?>);scroll();return false;" class="commentAnswer">Ответить</a> 
						</div>
					</div>

					<?php if(!empty($subcomments)): ?>
						<?php foreach ($subcomments as $subcomment) { ?>

							<div class="comment-item clearfix">
								<div class="clearfix">
									<a href="" class="user-img-box">
									    <img src="/<?php echo $subcomment->user->avatar; ?>" width="75" height="75" alt="">
									</a>
									<div class="comment-body">
										<div class="userComment-info">
											<a href="/profile/profile/views/id/<?php echo $comment->user->id; ?>" class="userComment-name"><?php echo $subcomment->user->username; ?></a>,  
											<span class="userComment-date"><?php echo date("d F Y, H:i", strtotime($subcomment->created)); ?></span>
										</div> 
										<p class="userComment-text"><?php echo $subcomment->comment; ?></p>
										<a href="" onClick="$('#answer_id').val(<?php echo $comment->id; ?>);scroll();return false;" class="commentAnswer">Ответить</a> 
									</div>
								</div>
							</div><!--comment-item END-->

						<?php } ?>
					<?php endif; ?>

				</div><!--comment-item END-->

			<?php	} ?>

			</div>
			<!-- END commentsBox -->
		</div>
	</div>
	<!-- END wrapper -->
	<!-- BEGIN push -->
	<div class="push"></div>
	<!-- END push -->
	<!-- BEGIN scrollTop -->
	<a href="#top" class="scrolltop">вверх<i class="ico ico_scrolltop"></i></a>
	<div class="height"></div>
	<!-- END scrollTop -->

