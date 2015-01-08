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

		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$posts,
			'summaryText' => '',
			'itemView'=>'_view',
			'pager'=>array(
		        'header'         => '',
		        'firstPageLabel' => '',
		        'prevPageLabel'  => '',
		        'nextPageLabel'  => '',
		        'lastPageLabel'  => '',
		        'cssFile' => '',
		    ),
		)); ?>

	</div>
	<!-- END wrapper -->
	<!-- BEGIN scrollTop -->
	<a href="#top" class="scrolltop">вверх<i class="ico ico_scrolltop"></i></a>
	<div class="height"></div>
	<!-- END scrollTop -->
